<?php
namespace weha\UBL\Invoice;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class OrderReference implements XmlSerializable {
	private $id;

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
		return $this;
	}

	function xmlSerialize(Writer $writer) {
		$writer->write([
			Schema::CBC . 'ID' => $this->id,
		]);
	}
}
