<?php
namespace FeatValue\Exceptions;

class ValidationException extends \Exception{
	private $errors = null;

	public function setErrors(array $errors) : self{
		$this->errors = $errors;
		return $this;
	}

	public function getErrors() : self{
		return $this->errors;
	}
}
