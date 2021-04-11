<?php

namespace Laramage\Blade\View\TemplateEngine;

use Laramage\Blade\View\ViewFactory;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\View\Element\BlockInterface;
use Magento\Framework\View\TemplateEngineInterface;

class Blade implements TemplateEngineInterface
{
    /**
     * @var ObjectManagerInterface
     */
    protected ObjectManagerInterface $helperFactory;

    /**
     * @var array
     */
    protected array $blockVariables;

    /**
     * @var ViewFactory
     */
    protected ViewFactory $viewFactory;

    /**
     * Blade constructor.
     * @param ObjectManagerInterface $helperFactory
     * @param ViewFactory $viewFactory
     * @param array $blockVariables
     */
    public function __construct(
        ObjectManagerInterface $helperFactory,
        ViewFactory $viewFactory,
        array $blockVariables = []
    ) {
        $this->helperFactory = $helperFactory;
        $this->blockVariables = $blockVariables;
        $this->viewFactory = $viewFactory;
    }

    /**
     * @param BlockInterface $block
     * @param string $templateFile
     * @param array $dictionary
     * @return string|void
     */
    public function render(BlockInterface $block, $templateFile, array $dictionary = []): string
    {
        // Step 1: preapre the view, passing the block as reference
        $view = $this->viewFactory
            ->create(['viewPath' => $templateFile])
            ->append(array_merge(['block' => $block], $this->blockVariables, $dictionary));

        // Step 2: render the output as html
        $html = $view->render();
        // Step 3: return the rendered html
        return $html;
    }
}
