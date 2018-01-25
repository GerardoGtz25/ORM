<?php

class Query {

	private $sqltable;
	private $fields = '*';
	private $where = null;
	private $args = [];
	private $sql = '';

	public static function table(string $table){
		$query = new Query;
		$query->sqltable= $table;
		return $query;
	}

	public function where($col, $op, $val){
		if(!is_null($this->where)) $this->where .= ' and ';

		$this->where .= ' ' . $col . ' ' . $op.' ? ';
		$this->args[]=$val;
		return $this;
	}

	public function get() {
		$this->sql ='select '.$this->fields.' from '.$this->sqltable;

		if (!is_null($this->where)) {
			$this->sql .= ' where' .$this->where;
		}

		$db = connectionFactory::getConnection();

		$stmt = $db->prepare($this->sql);
		$stmt->execute($this->args);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function first(){
		$this->sql ='select '.$this->fields.' from '.$this->sqltable;

		if (!is_null($this->where)) {
			$this->sql .= ' where' .$this->where;
		}

		$db = connectionFactory::getConnection();
		$this->sql.=' LIMIT 1';
		$stmt = $db->prepare($this->sql);
		$stmt->execute($this->args);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function select (array $fields) {
		$this->fields = implode( ',', $fields);
		return $this;
	}

	public function delete(){
		$this->sql = 'delete from '.$this->sqltable;

		if(!is_null($this->where))
		$this->sql .= ' where '. $this->where;

		$db = connectionFactory::getConnection();
		$stmt = $db->prepare($this->sql);
		return $stmt->execute($this->args);
	}

	public function insert(array $t) {
		$into = [];
		$values=[];

		$this->sql = 'insert into '.$this->sqltable;

		foreach($t as $attr_name => $attval){
			$into[]=$attr_name;
			$values[]=' ? ';
			$this->args[]=$attval;
		}
		$this->sql.= ' ('. implode(',',$into).') '.'values ('.implode(',',$values).')';
		$db = connectionFactory::getConnection();
		$stmt = $db->prepare($this->sql);
		$stmt->execute($this->args);
		return (int)$db->lastInsertId($this->sqltable);
	}
}
