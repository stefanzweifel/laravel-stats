<?php declare(strict_types=1);

namespace Wnx\LaravelStats\ShareableMetrics;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

class ProjectName
{
    public const RC_FILE = '.laravelstatsrc';

    public function get(): ?string
    {
        if ($this->hasStoredProjectName()) {
            return File::get($this->pathToRcFile());
        }

        return null;
    }

    public function determineProjectNameFromGit(): ?string
    {
        $gitPath = $this->getGitBinaryPath();

        if (is_null($gitPath)) {
            return null;
        }

        $process = Process::fromShellCommandline("{$gitPath} config --get remote.origin.url");
        $process->run();

        if ($process->isSuccessful() === false) {
            return null;
        }

        $remoteUrl = parse_url(trim($process->getOutput()));

        $remoteUrl = Str::replaceLast('.git', '', $remoteUrl['path']);

        return Str::replaceFirst('/', '', $remoteUrl);
    }

    protected function getGitBinaryPath(): ?string
    {
        $process = Process::fromShellCommandline('which git');
        $process->run();

        if ($process->isSuccessful() === false) {
            return null;
        }

        return trim($process->getOutput());
    }

    protected function pathToRcFile(): string
    {
        return base_path(self::RC_FILE);
    }

    public function hasStoredProjectName(): bool
    {
        return File::exists($this->pathToRcFile());
    }

    public function storeNameInRcFile(string $projectName): void
    {
        File::put($this->pathToRcFile(), $projectName);
    }
}
