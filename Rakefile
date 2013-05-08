namespace :deploy do
    task :live do
        push_to_deploy_branch('live')
    end
end

def push_to_deploy_branch(to_branch)
    target_repo = to_branch
    active_branch = `git rev-parse --abbrev-ref HEAD`
    system 'git checkout deploy/' + to_branch
    system 'git merge ' + active_branch
    system 'git checkout ' + active_branch
    system 'git push ' + target_repo + ' deploy/' + to_branch + ':deploy/' + to_branch
end

