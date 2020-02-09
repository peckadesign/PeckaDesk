<?php declare(strict_types = 1);

namespace PeckaDesk\Model\UsersOnProjects;

/**
 * @\Doctrine\ORM\Mapping\Entity
 * @\Doctrine\ORM\Mapping\Table(name="user_x_project")
 */
class UserOnProject implements \Nette\Security\IRole
{

	/**
	 * @\Doctrine\ORM\Mapping\Id
	 * @\Doctrine\ORM\Mapping\ManyToOne(targetEntity="\PeckaDesk\Model\Users\User")
	 */
	private \PeckaDesk\Model\Users\User $user;

	/**
	 * @\Doctrine\ORM\Mapping\Id
	 * @\Doctrine\ORM\Mapping\ManyToOne(targetEntity="\PeckaDesk\Model\Projects\Project", inversedBy="allowedProjects")
	 */
	private \PeckaDesk\Model\Projects\Project $project;

	/**
	 * @\Doctrine\ORM\Mapping\Column(type="string")
	 */
	private string $role;


	public function __construct(
		\PeckaDesk\Model\Users\User $user,
		\PeckaDesk\Model\Projects\Project $project,
		string $role
	)
	{

		$this->user = $user;
		$this->project = $project;
		$this->role = $role;
	}


	public function getId(): string
	{
		return $this->user->getId() . '-' . $this->project->getId();
	}


	public function getUser(): \PeckaDesk\Model\Users\User
	{
		return $this->user;
	}


	public function getProject(): \PeckaDesk\Model\Projects\Project
	{
		return $this->project;
	}


	public function getRole(): string
	{
		return $this->role;
	}


	function getRoleId(): string
	{
		return $this->project->getId() . '-' . $this->role;
	}

}
