<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Grids;

final class BaseFactory
{

	private \Nette\Localization\ITranslator $translator;


	public function __construct(
		\Nette\Localization\ITranslator $translator
	)
	{
		$this->translator = $translator;
	}


	public function create(): \Ublaboo\DataGrid\DataGrid
	{
		$dataGrid = new \Ublaboo\DataGrid\DataGrid();

		$dataGrid->setTranslator($this->translator);

		return $dataGrid;
	}

	public function createDetailButton(\Ublaboo\DataGrid\DataGrid $dataGrid, string $href, callable $conditionCallback): void
	{
		$dataGrid
			->addAction('detail', 'detail', $href)
			->setRenderer(static function ($entity) use ($href, $dataGrid): \Nette\Utils\Html {
				return \Nette\Utils\Html::el('a', ['href' => $dataGrid->getPresenter()->link($href, [$entity]), 'class' => 'btn btn-info'])->setText($dataGrid->getTranslator()->translate('detail'));
			})
			->setRenderCondition($conditionCallback)
		;
	}


	public function createEditButton(\Ublaboo\DataGrid\DataGrid $dataGrid, string $href, callable $conditionCallback): void
	{
		$dataGrid
			->addAction('edit', 'edit', $href)
			->setRenderer(static function ($entity) use ($href, $dataGrid): \Nette\Utils\Html {
				return \Nette\Utils\Html::el('a', ['href' => $dataGrid->getPresenter()->link($href, [$entity]), 'class' => 'btn btn-warning'])->setText($dataGrid->getTranslator()->translate('edit'));
			})
			->setRenderCondition($conditionCallback)
		;
	}


	/**
	 * @param array<mixed> $params
	 */
	public function createAddButton(\Ublaboo\DataGrid\DataGrid $dataGrid, string $href, array $params = []): void
	{
		$dataGrid
			->addToolbarButton($href, 'add', $params)
			->setClass('btn btn-success');
	}

}
