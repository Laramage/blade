<?php

namespace Laramage\Blade\View;

use Illuminate\View\Compilers\BladeCompilerFactory;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Engines\CompilerEngineFactory;
use Magento\Framework\Filesystem\DirectoryList;

class View
{
    /**
     * @var string
     */
    protected string $viewPath;

    /**
     * @var CompilerEngineFactory
     */
    protected CompilerEngineFactory $compilerEngineFactory;

    /**
     * @var array
     */
    protected array $viewParams = [];

    /**
     * @var CompilerEngine
     */
    protected $compiler;

    /**
     * @var BladeCompilerFactory
     */
    protected BladeCompilerFactory $bladeCompilerFactory;
    /**
     * @var DirectoryList
     */
    protected DirectoryList $directoryList;
    protected \Magento\Framework\Filesystem\Io\File $io;

    /**
     * View constructor.
     * @param string $viewPath
     * @param CompilerEngineFactory $compilerEngineFactory
     * @param BladeCompilerFactory $bladeCompilerFactory
     * @param DirectoryList $directoryList
     * @param \Magento\Framework\Filesystem\Io\File $io
     */
    public function __construct(
        string $viewPath,
        CompilerEngineFactory $compilerEngineFactory,
        BladeCompilerFactory $bladeCompilerFactory,
        DirectoryList $directoryList,
        \Magento\Framework\Filesystem\Io\File $io
    ) {
        $this->viewPath = $viewPath;
        $this->compilerEngineFactory = $compilerEngineFactory;
        $this->bladeCompilerFactory = $bladeCompilerFactory;
        $this->directoryList = $directoryList;
        $this->io = $io;
    }

    /**
     * @return string
     */
    public function render(): string
    {
        return $this->getCompiler()->get($this->viewPath, $this->viewParams);
    }

    /**
     * @param array $viewParams
     * @return $this
     */
    public function append(array $viewParams): self
    {
        $this->viewParams = $viewParams;
        return $this;
    }

    protected function getCompiler(): CompilerEngine
    {
        if (!$this->compiler) {
            $cacheDir = $this->directoryList->getPath('var') . "/blade";
            $this->io->checkAndCreateFolder($cacheDir);
            $engine = $this->bladeCompilerFactory
                ->create(
                    ['cachePath' => $cacheDir]
                );

            // TODO extract to dedicated logic
            $engine->directive('renderChildren', function() {
                return '<?php echo $block->getChildHtml(); ?>';
            });

            $this->compiler = $this->compilerEngineFactory->create(['compiler' => $engine]);
        }
        return $this->compiler;
    }
}