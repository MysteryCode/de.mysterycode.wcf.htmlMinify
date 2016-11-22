<?php
namespace wcf\system\event\listener;

class HTMLMinifyListener implements IParameterizedEventListener {
	/**
	 * @inheritdoc
	 */
	public function execute($eventObj, $className, $eventName, array &$parameters) {
		/** @var $eventObj \wcf\util\HeaderUtil */
		$eventObj::$output = $this->sanitize_output($eventObj::$output);
	}

	public function sanitize_output($buffer) {
		$search = array(
			'/\>[^\S ]+/s',   // strip whitespaces after tags, except space
			'/[^\S ]+\</s',   // strip whitespaces before tags, except space
			'/(\s)+/s',       // shorten multiple whitespace sequences
			'/\/\/\<\!\[CDATA\[/',
			'/\/\/\]\]\>/'
		);

		$replace = array(
			'> ',
			' <',
			'\\1',
			'',
			''
		);

		$buffer = preg_replace($search, $replace, $buffer);

		return $buffer;
	}
}
