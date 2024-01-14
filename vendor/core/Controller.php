<?php

namespace Core;

abstract class Controller
{	
	// Render the twig pages	
	protected function render($view, $data = [])
	{
		$viewPath = $_SERVER['DOCUMENT_ROOT'] . "/views/";
		$loader = new \Twig\Loader\FilesystemLoader($viewPath);
		$twig = new \Twig\Environment($loader);

		$path = new \Core\Path();
        $twig->addFunction(new \Twig\TwigFunction('route', [$path, 'route']));

		return $twig->render($view, $data);
	}
    
	// JSON
	protected function response($data)
	{
		$json = json_encode($data);
		header('Content-Type: application/json');
		return $json;
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
    
	// Redirect
	protected function redirect($to)
	{
		header("Location: $to");
		return $this;
	}

	// Redirect to previous page
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

	// Cut part of url string
    public function cutUrlString($string)
    {
        if (isset($_SERVER['QUERY_STRING'])) {
            $query = $_SERVER['QUERY_STRING'];
            if (strpos($query, $string) !== false) {
                $query = preg_replace("/$string.*/", '', $query);
                $url = strtok($_SERVER['REQUEST_URI'], '?') . '?' . $query;
                return $url;
            }
            return '?' . $_SERVER['QUERY_STRING'];
        }  
    }
}