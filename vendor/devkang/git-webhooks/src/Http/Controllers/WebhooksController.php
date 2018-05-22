<?php
/**
 * Created by PhpStorm.
 * User: DevKang
 * Date: 2017/6/22
 * Time: 00:28
 */

namespace Devkang\Git\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\Process\Process;

class WebhooksController extends BaseController
{

    /**
     *
     * @param Request $request
     * @return string
     */
    public function index(Request $request)
    {
        $projectPath = base_path();
        $git_config = config('git');

        if (!empty($git_config['X-Gitlab-Token']) ) {
            if ($request->header('X-Gitlab-Token') != $git_config['X-Gitlab-Token']) {
                return $this->noAuthentication();
            }
        }
        if (!empty($git_config['X-Hub-Signature'])) {
            if ($request->header('X-Hub-Signature') != $git_config['X-Hub-Signature']) {
                return $this->noAuthentication();
            }
        }
        // merge commands
        $commands = array_merge($git_config['git_commands'], $git_config['migration_commands'], $git_config['commands']);
        $result = [];

        foreach ($commands as $command) {
            $result[] = $this->runLocalShell($command, $projectPath);
        }
        return $result;
    }

    /**
     * 执行本地shell
     *
     * @author DevKang
     * @date 2016年7月20日
     */
    public function runLocalShell($cmd, $cwd = null)
    {
        $process = new Process($cmd);
        if ($cwd) {
            $process->setWorkingDirectory($cwd);
        }
        $process->run();
        if ($process->getExitCode() != 0) {
            return $process->getErrorOutput();
        }
        return $process->getOutput();
    }

    public function noAuthentication()
    {
        return response('Authentication failure')->setStatusCode(401);
    }
}