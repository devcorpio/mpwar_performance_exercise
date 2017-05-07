<?php

namespace Performance\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Performance\Domain\UseCase\SignUp;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Aws\S3\S3Client;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use League\Flysystem\Filesystem;
use League\Flysystem\Config;

class RegisterController
{
    /**
     * @var \Twig_Environment
     */
    private $template;

    /**
     * @var UrlGeneratorInterface
     */
    private $url_generator;

    /**
     * @var SignUp
     */
    private $useCase;

    public function __construct(\Twig_Environment $templating, UrlGeneratorInterface $url_generator, SignUp $useCase) {
        $this->template = $templating;
        $this->url_generator = $url_generator;
        $this->useCase = $useCase;
    }

    public function get()
    {
        return new Response($this->template->render('register.twig'));
    }

    public function post(Request $request)
    {
    	$username = $request->request->get('username');
    	$password = $request->request->get('password');
        $image = $request->files->get('image');

    	$this->useCase->execute($username, $password);
    	$this->uploadImage($image);




        return new RedirectResponse($this->url_generator->generate('login'));
    }

    private function uploadImage($image) {
        $imageExtension = $image->getClientOriginalExtension();
        $client = new S3Client([
            'credentials' => [
                'key'    => 'AKIAIJOKMDIO2GIE2CIA',
                'secret' => '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',
            ],
            'region' => 'eu-west-1',
            'version' => 'latest',
        ]);

        $aws3adapter = new AwsS3Adapter($client, 'mpwarpracticaperformance');


        $filesystem = new Filesystem($aws3adapter, new Config([]));
        $filesystem->write(microtime(true).'.'.$imageExtension, file_get_contents($image->getPathname()));
    }
}