<?php

namespace Core;

use Core\Database;
use PDO;

class Model
{
	protected static $link;
	protected $table;

	public function __construct()
	{
		self::$link = Database::getInstance()->getPdo();
	}

	public function find($value, $column = 'id')
	{
		$query = self::$link->prepare("SELECT * FROM " . $this->table . " WHERE $column = :value");
		$query->execute([':value' => $value]);

		return $query->fetch(PDO::FETCH_ASSOC);
	}

	public function create(array $data)
	{
		$fields = implode(', ', array_keys($data));
		$values = implode(', :', array_keys($data));
		$query = "INSERT INTO " . $this->table . " ($fields) VALUES (:$values)";
		$stmt = self::$link->prepare($query);
		foreach ($data as $key => $value) {
			$stmt->bindValue(":$key", $value);
		}
		$stmt->execute();

		if (isset($_SESSION['csrf_token'])) {
			unset($_SESSION['csrf_token']);
		}
	}

	public function findAll($get = '', array $data = [])
	{
		$query = self::$link->prepare("SELECT * FROM " . $this->table . " $get");
		$query->execute($data);
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

	public function findSpecific($get, array $data = [])
	{
		$query = self::$link->prepare("SELECT * FROM " . $this->table . " $get");
		$query->execute($data);
		return $query->fetch(PDO::FETCH_ASSOC);
	}

	public function update($element, string $column, array $data)
	{
		$query = "UPDATE " . $this->table . " SET ";
		$update_fields = [];
		foreach ($data as $key => $value) {
			$update_fields[] = "$key = :$key";
		}
		$query .= implode(', ', $update_fields);
		$query .= " WHERE $column = :element";
		$stmt = self::$link->prepare($query);
		$stmt->bindValue(':element', $element);
		foreach ($data as $key => $value) {
			$stmt->bindValue(":$key", $value);
		}
		$stmt->execute();

		if (isset($_SESSION['csrf_token'])) {
			unset($_SESSION['csrf_token']);
		}
	}

	public function delete($element, $column = 'id')
	{
		$query = self::$link->prepare("DELETE FROM " . $this->table . " WHERE $column = :element");
		$query->execute([':element' => $element]);

		if (isset($_SESSION['csrf_token'])) {
			unset($_SESSION['csrf_token']);
		}
	}
}