@servers(['localhost' => ['127.0.0.1']])

@task('deploy', ['on' => 'localhost'])
    ls -la
@endtask
