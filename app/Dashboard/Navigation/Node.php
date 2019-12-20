<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Navigation;

final class Node
{

	public const BADGE_STATE_SUCCESS = 'success';
	public const BADGE_STATE_INFO = 'info';
	public const BADGE_STATE_SECONDARY = 'secondary';

	private ?string $label = NULL;

	private ?Node $parent = NULL;

	/**
	 * @var array<Node>
	 */
	private array $children = [];

	/**
	 * @var array<string, Node>
	 */
	private array $directory = [];

	private bool $active = FALSE;

	private bool $allowed = FALSE;

	private bool $selected = FALSE;

	private string $presenter;

	private string $action;

	/**
	 * @var array<mixed>
	 */
	private array $parameters = [];

	private ?string $badge = NULL;

	private ?string $badgeState = NULL;


	public function getLabel(): ?string
	{
		return $this->label;
	}


	public function setLabel(string $label): void
	{
		$this->label = $label;
	}


	public function getParent(): ?Node
	{
		return $this->parent;
	}


	public function setParent(Node $parent): void
	{
		$this->parent = $parent;
	}


	/**
	 * @return array<Node>
	 */
	public function getChildren(): array
	{
		return \array_filter($this->children, static function (Node $node) {
			return $node->isAllowed();
		});
	}


	public function addChild(Node $child): void
	{
		$this->children[] = $child;
		$child->parent = $this;
		$this->addToDirectory($child);
		if ($child->isActive()) {
			$this->setActive($child->isActive());
		}
	}


	public function addChildAfter(
		Node $child,
		Node $after
	): void
	{
		$position = 0;
		foreach ($this->children as $currentChild) {
			if ($currentChild === $after) {
				\array_splice($this->children, $position + 1, 0, [$child]);
				break;
			}
			$position++;
		}
		$child->parent = $this;
		$this->addToDirectory($child);
		if ($child->isActive()) {
			$this->setActive($child->isActive());
		}
	}


	public function addChildBefore(
		Node $child,
		?Node $before
	): void
	{
		if ($before === NULL) {
			$this->addChild($child);

			return;
		}

		$position = 0;
		foreach ($this->children as $currentChild) {
			if ($currentChild === $before) {
				\array_splice($this->children, $position, 0, [$child]);
				break;
			}
			$position++;
		}
		$child->parent = $this;
		$this->addToDirectory($child);
		if ($child->isActive()) {
			$this->setActive($child->isActive());
		}
	}


	private function addToDirectory(Node $node): void
	{
		if ($this->parent !== NULL) {
			$this->parent->addToDirectory($node);
		} else {
			if ($node->hasLink()) {
				$this->directory[$node->getLink()] = $node;
			}
		}
	}


	/**
	 * Nalezne potomka podle předaného odkazu
	 */
	public function getChild(string $link): ?Node
	{
		return isset($this->directory[$link]) ? $this->directory[$link] : NULL;
	}


	public function isActive(): bool
	{
		return $this->active;
	}


	private function setActive(bool $active): void
	{
		$this->active = $active;
		if ($this->parent && $active) {
			$this->parent->setActive($active);
		}
	}


	public function isAllowed(): bool
	{
		return $this->allowed;
	}


	public function setAllowed(bool $allowed): void
	{
		$this->allowed = $allowed;
	}


	public function isSelected(): bool
	{
		return $this->selected;
	}


	public function setSelected(bool $selected): void
	{
		$this->selected = $selected;
		if ($selected) {
			$this->setActive($selected);
		}
	}


	/**
	 * @param array<mixed> $parameters
	 */
	public function setLink(string $presenter, string $action, array $parameters = []): void
	{
		$this->presenter = $presenter;
		$this->action = $action;

		if (isset($parameters['_fid'])) {
			unset($parameters['_fid']);
		}

		$this->parameters = $parameters;
		$this->addToDirectory($this);
	}


	public function hasLink(): bool
	{
		return (bool) $this->presenter;
	}


	public function getLink(): string
	{
		return $this->presenter . ':' . $this->action;
	}


	/**
	 * @return array<mixed>
	 */
	public function getParameters(): array
	{
		return $this->parameters;
	}


	/**
	 * Vrátí uzel označený jako selected. Buď aktuální uzel, nebo potomka. Vyhledává podle cesty označené příznakem active
	 */
	public function getSelected(): Node
	{
		if ($this->isSelected()) {
			return $this;
		}

		if ( ! $this->active && $this->parent) {
			return $this->parent->getSelected();
		}

		foreach ($this->getChildren() as $child) {
			if ($child->isActive()) {
				return $child->getSelected();
			}
		}

		throw new \RuntimeException();
	}


	public function setBadge(string $badge, string $badgeState = self::BADGE_STATE_INFO): void
	{
		$this->badge = $badge;
		$this->badgeState = $badgeState;
	}


	public function getBadge(): ?string
	{
		return $this->badge;
	}


	public function getBadgeState(): ?string
	{
		return $this->badgeState;
	}

}
