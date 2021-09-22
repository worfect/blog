import $ from "jquery";

const notice = require('./vendor/notice/messages')

export default class Form {
    form;
    formData;
    url;
    urlRefresh;
    refreshSection;
    noticeSection;

    constructor(form, url) {
        this.form = form;
        this.url = url;
        this.formData = new FormData(form.get(0));
    }

    _cleanInvalid() {
        this.form.find('.invalid-feedback')
            .remove()

        this.form.find('.is-invalid')
            .removeClass('is-invalid')
    }

    _ajaxSendForm() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: this.url,
                method: 'POST',
                dataType: 'JSON',
                processData: false,
                contentType: false,
                data: this.formData
            })
            .done(function (data) {
                resolve(data);
            })
            .fail(function (data) {
                reject(data);
            })
        })
    }

    _responseProcessing() {
        return new Promise((resolve, reject) => {
            this._ajaxSendForm()
                .then((data) => {
                    this._cleanInvalid();
                    if (this.noticeSection) {
                        notice.showNoticeMessages(data, this.noticeSection);
                    }
                    if (this.refreshSection) {
                        this._refreshContent()
                    }
                    resolve(true);
                })
                .catch((data) => {
                    this._cleanInvalid();
                    let errors = data.responseJSON.errors;

                    $.each(errors, function (name, message) {
                        let span = document.createElement('span');
                        let strong = document.createElement('strong');
                        let field = $('[name = ' + name + ']');

                        strong.innerHTML = message;

                        $(span).attr({"class": "invalid-feedback", "role": "alert"})
                            .html(strong);

                        field.addClass("is-invalid")
                            .after(span);
                    });

                    reject(false);
                })
        })
    }

    _refreshContent() {
        let refreshSection = this.refreshSection
        $.ajax({
            url: this.urlRefresh,
            method: 'POST',
            dataType: 'HTML',
            processData: false,
            contentType: false,
            data: this.formData
        })
            .done(function (data) {
                $(refreshSection).empty();
                $(refreshSection).append(data);
            })
            .fail(function (data) {

            })
    }

    submitForm() {
        return this._responseProcessing()
            .then((data) => {
                return data;
            })
            .catch((data) => {
                return data;
            })
    }

    withRefresh(urlRefresh, section) {
        this.urlRefresh = urlRefresh
        this.refreshSection = section;
        return this
    }

    withNotice(section) {
        this.noticeSection = section;
        return this
    }
}
