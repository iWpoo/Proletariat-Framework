<?php

namespace Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

class Controller
{	
    protected $twig;

    /* Initializing the Twig  */
	protected function initTwig()
    {
        $loader = new FilesystemLoader($_SERVER['DOCUMENT_ROOT'] . "/views/");
        $this->twig = new Environment($loader);
        $this->initTwigFunctions();
    }

	/* Render the twig page */
	protected function render($view, $data = [])
	{
		if (!$this->twig) {
            $this->initTwig();
        }
		
		return $this->twig->render($view . '.twig', $data);
	}

	private function initTwigFunctions()
	{
		$path = new \Core\Path();
        $this->twig->addFunction(new TwigFunction('route', [$path, 'route']));
	}
    
	// Add post element with xss defence
	protected function add($element, string $way = 'htmlspecialchars')
	{
		if ($way === 'htmlspecialchars') {
			return htmlspecialchars(trim($_POST[$element]));
		} else if ($way === 'strip_tags') {
			return strip_tags(trim($_POST[$element]));
		}
	}

    // Upload files
	protected function uploadFile($file, $filename, $path)
	{
		$allPath = '/public/' . $path . '/';
		$destination = $_SERVER['DOCUMENT_ROOT'] . $allPath . $filename;
		move_uploaded_file($file['tmp_name'], $destination);
	}

	protected function uniqueNameFile($file, $allowed_extensions = ["png", "jpg", "mp4", "gif", "jpeg"])
	{
		$file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
		$filename = bin2hex(random_bytes(32)) . '.' . $file_extension;
		return $filename;
	}
    
	protected function redirect($to = null)
    {
        if ($to !== null) {
            header("Location: $to");
            exit();
        }

        return $this;
    }

    protected function route($name)
    {
        $path = (new \Core\Path)->route($name);
        $this->redirect($path);
    }

	protected function back()
	{	
		$this->redirect($_SERVER['HTTP_REFERER']);
	}
	
	// CSRF token
	protected function generateCsrfToken()
	{
		if (!isset($_SESSION['csrf_token'])) {
			$token = bin2hex(random_bytes(32));
			$_SESSION['csrf_token'] = $token;
		} else {
			$token = $_SESSION['csrf_token'];
		}
		return $token;
	}
}