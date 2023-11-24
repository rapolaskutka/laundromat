<?php

namespace App\Rules;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;

class YodaExpressionRule implements Rule
{
    public function getNodeType(): string
    {
        return Node\Expr\BinaryOp::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if (!$node instanceof Node\Expr\BinaryOp) {
            return [];
        }

        $isYodaCondition = $node->left instanceof Node\Scalar ||
            $node->left instanceof Node\Expr\ConstFetch &&
            $node->right instanceof Node\Expr\Variable;

        if ($isYodaCondition) {
            return ['Yoda expression detected'];
        }

        return [];
    }
}
