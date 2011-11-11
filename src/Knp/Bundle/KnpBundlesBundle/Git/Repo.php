<?php

namespace Knp\Bundle\KnpBundlesBundle\Git;

use Knp\Bundle\KnpBundlesBundle\Entity\Repo as RepoEntity;

class Repo
{
    /**
     * Git repository wrapper
     *
     * @var \PHPGit_Repository
     */
    protected $gitRepo = null;

    /**
     * Repo entity
     *
     * @var RepoEntity
     */
    protected $entity = null;

    public function __construct(RepoEntity $repoEntity, \PHPGit_Repository $gitRepo)
    {
        $this->entity = $repoEntity;
        $this->gitRepo = $gitRepo;
    }

    public function update()
    {
        $this->getGitRepo()->git('pull origin HEAD');
    }

    public function getCommits($nb)
    {
        $commits = $this->getGitRepo()->getCommits(12);
        foreach ($commits as $key => $commit) {
            $commits[$key]['url'] = $this->entity->getGithubUrl().'/commit/'.$commit['id'];
        }

        return $commits;
    }

    public function hasFile($file)
    {
        return file_exists($this->gitRepo->getDir().'/'.$file);
    }

    public function getFileContent($file)
    {
        return file_get_contents($this->gitRepo->getDir().'/'.$file);
    }

    /**
     * Get gitRepo
     *
     * @return \PHPGit_Repository
     */
    public function getGitRepo()
    {
      return $this->gitRepo;
    }

    /**
     * Set gitRepo
     *
     * @param \PHPGit_Repository
     * @return null
     */
    public function setGitRepo($gitRepo)
    {
      $this->gitRepo = $gitRepo;
    }

    /**
     * Get entity
     *
     * @return RepoEntity
     */
    public function getRepoEntity()
    {
      return $this->entity;
    }

    /**
     * Set entity
     *
     * @param  RepoEntity
     * @return null
     */
    public function setRepoEntity($entity)
    {
      $this->entity = $entity;
    }

    /**
     * Returns the git repository directory
     *
     * @return string
     */
    public function getDir()
    {
        return $this->gitRepo->getDir();
    }
}
