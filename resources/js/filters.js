//content-filter
$('#content-method')
    .change(switchSelects)
    .ready(switchSelects);


function switchSelects(){
    if($("#content-method option:selected").val() === 'best'){
        $('#content-criterion').prop('disabled', false);
        $('#content-date').prop('disabled', false);
    }else{
        $('#content-criterion').prop('disabled', true);
        $('#content-date').prop('disabled', true);
    }
}


