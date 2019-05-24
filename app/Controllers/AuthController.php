<?php
namespace App\Controllers;

use App\Models\User;
use Respect\Validation\Validator as v;
use Zend\Diactoros\Response\RedirectResponse;

class AuthController extends BaseController {

    public function getLogin() {

        return $this->renderHTML('login.twig');
    }

    public function postLogin($request) {

        $postData = $request->getParsedBody();
        $responseMessage = null;
        $user = User::where('email', $postData['email'])->first();
        if($user) {
            if (password_verify($postData['password'], $user->password)){
                $_SESSION['userId'] = $user->id;
                return new RedirectResponse('/curso-introduccion-php/admin');
            } else {
                $responseMessage = 'Bad Credentials';
            }
        } else {
            $responseMessage = 'Bad Credentials';
        }

        return $this->renderHTML('login.twig', [
            'responseMessage' => $responseMessage
        ]);
    }

    public function getLogout() {

        unset($_SESSION['userId']);
        return new RedirectResponse('/curso-introduccion-php/login');
    }

    public function getLoginRequired()
   	{
     	return new RedirectResponse('/curso-introduccion-php/login');
   	}
}