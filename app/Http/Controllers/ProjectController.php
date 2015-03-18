<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Project;
use App\Deployment;
use App\Commands\QueueDeployment;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * The details of an individual project
     *
     * @param int $project_id The ID of the project to display
     * @return \Illuminate\View\View
     */
    public function details($project_id)
    {
        $project = Project::find($project_id);

        return view('project.details', [
            'title'              => $project->name,
            'deployments'        => $project->deployments, // Get only the last x?
            'project'            => $project,
            'servers'            => $project->servers, // Order by name
            'is_project_details' => true
        ]);
    }

    public function deploy($project_id)
    {
        $project = Project::findOrFail($project_id);
        $deployment = new Deployment;

        $this->dispatch(new QueueDeployment($project, $deployment));

        return view('project.deploy', [
            'title'      => 'Deploying project....',
            'project'    => $project,
            'deployment' => $deployment,
            'steps'      => $deployment->steps
        ]);
    }

    public function deployment($project_id, $deployment_id)
    {
        $project = Project::findOrFail($project_id);
        $deployment = Deployment::findOrFail($deployment_id);

        return view('project.deploy', [
            'title'      => 'Deployment # details',
            'project'    => $project,
            'deployment' => $deployment,
            'steps'      => $deployment->steps
        ]);
    }

    public function commands($project_id, $command)
    {
        return view('project.commands', [
            'title'   => 'project ' . $project_id . ' command ' . $command,
            'command' => $command
        ]);
    }
}
