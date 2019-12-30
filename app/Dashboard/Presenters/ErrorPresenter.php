<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Presenters;

final class ErrorPresenter implements \Nette\Application\IPresenter
{

	/** @var \Psr\Log\LoggerInterface */
	private $logger;


	public function __construct(\Psr\Log\LoggerInterface $logger)
	{
		$this->logger = $logger;
	}


	public function run(\Nette\Application\Request $request): \Nette\Application\IResponse
	{
		$e = $request->getParameter('exception');

		if ($e instanceof \Nette\Application\BadRequestException) {
			[$module, , $sep] = \Nette\Application\Helpers::splitName($request->getPresenterName());
			$errorPresenter = $module . $sep . 'Error4xx';

			return new \Nette\Application\Responses\ForwardResponse($request->setPresenterName($errorPresenter));
		}

		$this->logger->error($e);

		return new \Nette\Application\Responses\CallbackResponse(static function (\Nette\Http\IRequest $httpRequest, \Nette\Http\IResponse $httpResponse): void {
			if (\preg_match('#^text/html(?:;|$)#', (string) $httpResponse->getHeader('Content-Type')) !== FALSE) {
				require __DIR__ . '/templates/Error/500.phtml';
			}
		});
	}
}
