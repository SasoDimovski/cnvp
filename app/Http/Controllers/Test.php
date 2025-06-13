<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use Modules\Auth\Repositories\AuthRepositories;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Component\Mime\Email;
class Test
{
    public function __construct(private readonly AuthRepositories $authRepository)
    {}
    public function test(): void
    {
//        $transport = new EsmtpTransport('hp.cnvp-eu.org', 465);
//        $transport->setusername('webmaster@hp.cnvp-eu.org');
//        $transport->setPassword('BuQ3{m6h3%-U');
//
//        $mailer = new Mailer($transport);
//
//        $email = (new Email())
//            ->from('webmaster@hp.cnvp-eu.org')
//            ->to('saso.dimovski@t.mk')
//            ->subject('Test Email')
//            ->text('This is a test.');
//
//        $mailer->send($email);

        $deleteHash=$this->authRepository->deleteHash(10);
        $deleteVerificationCode=$this->authRepository->deleteVerificationCode(10);

        Session::forget('password');
        Session::forget('hash');
        Session::forget('id_user');
        Session::forget('email');
        Session::forget('mfa');

}}
