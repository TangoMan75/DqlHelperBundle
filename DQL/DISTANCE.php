<?php

namespace TangoMan\DqlHelperBundle\DQL;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\AST;

/**
 * DISTANCE(LatitudeFrom, LongitudeFrom, LatitudeTo, LongitudeTo)
 */
class DISTANCE extends FunctionNode
{
    /**
     * @var AST\AggregateExpression|AST\Functions\FunctionNode|AST\InputParameter|AST\Literal|AST\ParenthesisExpression|AST\PathExpression|mixed
     */
    protected $fromLat;

    /**
     * @var AST\AggregateExpression|AST\Functions\FunctionNode|AST\InputParameter|AST\Literal|AST\ParenthesisExpression|AST\PathExpression|mixed
     */
    protected $fromLng;

    /**
     * @var AST\AggregateExpression|AST\Functions\FunctionNode|AST\InputParameter|AST\Literal|AST\ParenthesisExpression|AST\PathExpression|mixed
     */
    protected $toLat;

    /**
     * @var AST\AggregateExpression|AST\Functions\FunctionNode|AST\InputParameter|AST\Literal|AST\ParenthesisExpression|AST\PathExpression|mixed
     */
    protected $toLng;

    /**
     * @param Parser $parser
     */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->fromLat = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_COMMA);
        $this->fromLng = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_COMMA);
        $this->toLat = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_COMMA);
        $this->toLng = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    /**
     * @param SqlWalker $sqlWalker
     *
     * @return string
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        $earthDiameterInKM = 1.609344 * 3956 * 2;
        $sql = '('.$earthDiameterInKM.' * ASIN(SQRT(POWER('.
            'SIN(('.$this->fromLat->dispatch($sqlWalker).' - ABS('.$this->toLat->dispatch($sqlWalker).')) * PI() / 180 / 2), 2) + '.
            'COS('.$this->fromLat->dispatch($sqlWalker).' * PI() / 180) * COS(ABS('.$this->toLat->dispatch($sqlWalker).') * PI() / 180) * '.
            'POWER(SIN(('.$this->fromLng->dispatch($sqlWalker).' - '.$this->toLng->dispatch($sqlWalker).') * PI() / 180 / 2), 2) '.
            ')))';

        return $sql;
    }
}