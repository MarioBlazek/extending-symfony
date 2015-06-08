<?php

namespace MB\Bundle\ExtendingSymfonyBundle\Doctrine;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class DistanceFunction extends FunctionNode
{
	protected $from = [];

	protected $to = [];

	/**
	 * @param \Doctrine\ORM\Query\SqlWalker $sqlWalker
	 *
	 * @return string
	 */
	public function getSql(SqlWalker $sqlWalker)
	{
		$db = $sqlWalker->getConnection()->getDatabasePlatform();
		$sql = 'POW(%s - %s, 2) + POW(%s - %s, 2)';

		$sql = sprintf($sql,
			$this->from['latitude']->dispatch($sqlWalker),
			$this->to['latitude']->dispatch($sqlWalker),
			$this->from['longitude']->dispatch($sqlWalker),
			$this->to['longitude']->dispatch($sqlWalker)
		);

		$sql = $db->getSqrtExpression($sql);

		return $sql;
	}

	/**
	 * @param \Doctrine\ORM\Query\Parser $parser
	 *
	 * @return void
	 */
	public function parse(Parser $parser)
	{
		// Match DISTANCE ( (lat, long), (lat, long) )
		$parser->match(Lexer::T_IDENTIFIER);
		$parser->match(Lexer::T_OPEN_PARENTHESIS);

			// first (lat, long)
			$parser->match(Lexer::T_OPEN_PARENTHESIS);
			$this->from['latitude'] = $parser->ArithmeticPrimary();

			$parser->match(Lexer::T_COMMA);
			$this->from['longitude'] = $parser->ArithmeticPrimary();
			$parser->match(Lexer::T_CLOSE_PARENTHESIS);

			$parser->match(Lexer::T_COMMA);

			// second (lat, long)
			$parser->match(Lexer::T_OPEN_PARENTHESIS);
			$this->to['latitude'] = $parser->ArithmeticPrimary();

			$parser->match(Lexer::T_COMMA);
			$this->to['longitude'] = $parser->ArithmeticPrimary();
			$parser->match(Lexer::T_CLOSE_PARENTHESIS);

		$parser->match(Lexer::T_CLOSE_PARENTHESIS);
	}
}