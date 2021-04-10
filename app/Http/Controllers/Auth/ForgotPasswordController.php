<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\PageController;
use App\Http\Requests\PasswordRecoveryRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class ForgotPasswordController extends PageController
{
    use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLinkRequestForm()
    {
        return $this->renderOutput('auth.passwords.email');
    }


    /**
     * @param PasswordRecoveryRequest $request
     * @return string
     */
    public function initializationSendMethod(PasswordRecoveryRequest $request)
    {

        $method = $this->getActiveMethod($request);
        if($method == 'login'){
            return $this->choiceAvailableResetMethod($request);
        }
        if($method == 'phone'){
            return $this->sendSmsResetMessage();
        }
        if($method == 'email'){
            return $this->sendEmailResetMessage($request);
        }
    }

    /**
     * Accessing user data when trying to reset a password using a login.
     * Return a redirect with a method in the session.
     *
     * @param PasswordRecoveryRequest $request
     * @return string
     */
    public function choiceAvailableResetMethod(PasswordRecoveryRequest $request)
    {
        $validData = $request->validated();
        $user = $this->broker()->getUser($validData);
        if (empty($user)){
            return $this->sendResetLinkFailedResponse('auth.failed');
        }
        $phone = $user->getAttribute('phone');
        $email = $user->getAttribute('email');
        if(empty($phone) and empty($email)){
            return $this->sendResetLinkFailedResponse('auth.no_data');
        }
        if($email and $phone){
            return $this->showSwitchMethods($email, $phone);
        }
        if(($phone and empty($email))){
            return redirect('password/message')->with([ 'method' => $phone ]);
        }
        if(($email and empty($phone))){
            return redirect('password/message')->with([ 'method' => $email ]);
        }
    }


    public function sendEmailResetMessage(PasswordRecoveryRequest $request)
    {
        $validData = $request->validated();
        $response = $this->broker()->sendResetLink($validData);
        if($response == Password::RESET_LINK_SENT){
            return $this->sendedEmailResetMessage();
        }else{
            return $this->sendResetLinkFailedResponse('auth.email_no_send');
        }
    }

    public function sendSmsResetMessage($validData){
        echo 'sendSms';
    }


    /**
     * Get the response for a successful password reset link.
     *
     * @return Application|Factory|JsonResponse|RedirectResponse|View
     */
    protected function sendedEmailResetMessage()
    {
        $this->template = 'layouts.notifications.success';
        $message = 'Reset link has been sent to email.';
        $this->insertData('message', $message);
        return $this->renderOutput('auth.passwords.email');
    }



    /**
     * Displaying the switch for selecting methods of password recovery.
     *
     * @param $email
     * @param $phone
     * @return string
     */
    public function showSwitchMethods($email, $phone){
        $this->template = 'auth.passwords.reset';
        $additionalData = [
            'switchResetMethod' => true,
            'email' => $this->preparingDisplayPrivateData($email),
            'phone' => $this->preparingDisplayPrivateData($phone)
        ];
        return redirect('password/reset')->with($additionalData)->withInput();
    }

    /**
     * @return string
     * @var string
     */
    protected function sendResetLinkFailedResponse($message)
    {
        return redirect('password/reset')
            ->withErrors(['uniqueness' => [trans($message)]]);
    }

    /**
     * Prepares personal data for display
     *
     * @return string
     * @var string
     */
    public function preparingDisplayPrivateData($data){
        return substr($data, 0, 4) . '***' . substr($data, -4, 4);
    }

    /**
     * @return string
     * @var string
     */
    public function getActiveMethod($request){
        $validData = $request->validated();
        $method = array_key_first($validData);
        if ($method == 'login'){
            if($request->get('method')){
                $method = $request->get('method');
            }
        }
        return $method;
    }
}
