<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\CQS\Resolver;


use App\Infrastructure\Http\CQS\CommandInterface;
use App\Infrastructure\Http\CQS\CqsInterface;
use App\Infrastructure\Http\CQS\QueryInterface;
use App\Infrastructure\Http\CQS\Resolver\Argument\ArgumentResolverInterface;
use App\Infrastructure\Http\Response\ResponseInterface;
use yii\base\Action;
use yii\base\Controller;
use yii\web\BadRequestHttpException;

class YiiActionExecutor extends Action
{
    private readonly ArgumentResolverInterface $argumentResolver;

    public function __construct(
        ?string $id,
        Controller $controller,
        ArgumentResolverInterface $argumentResolver,
        array $config = []
    ) {
        parent::__construct($id, $controller, $config);
        $this->argumentResolver = $argumentResolver;
    }

    public function run(CqsInterface $instance): mixed
    {
        if (!method_exists($instance, '__invoke')) {
            throw new \RuntimeException(sprintf('Method __invoke required in class %s', get_class($instance)));
        }

        $this->validate($instance);

        $arguments = $this->argumentResolver->getArguments($instance);

        /** @var callable $instance */
        $result = $instance(...$arguments);

        if (!$result instanceof ResponseInterface) {
            throw new \RuntimeException(
                sprintf(
                    'Method __invoke in class %s must return instance of %s',
                    get_class($instance),
                    ResponseInterface::class
                )
            );
        }

        return $result($this);
    }

    private function validate(CqsInterface $instance): void
    {
        if (!is_subclass_of($instance, CqsInterface::class)) {
            throw new \RuntimeException(
                sprintf('Class %s must implement only QueryInterface or CommandInterface', $instance::class)
            );
        }

        if ($instance instanceof QueryInterface) {
            if (!\Yii::$app->request->isGet) {
                throw new BadRequestHttpException('Request must be GET');
            }
        }

        if ($instance instanceof CommandInterface) {
            if (!\Yii::$app->request->isPost) {
                throw new BadRequestHttpException('Request must be POST');
            }
        }
    }
}