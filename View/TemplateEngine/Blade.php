<?php

namespace Laramage\Blade\View\TemplateEngine;

use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\View\TemplateEngineInterface;
use Magento\Framework\View\Element\BlockInterface;

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
     * Blade constructor.
     * @param ObjectManagerInterface $helperFactory
     * @param array $blockVariables
     */
    public function __construct(
        ObjectManagerInterface $helperFactory,
        array $blockVariables = []
    ) {
        $this->helperFactory = $helperFactory;
        $this->blockVariables = $blockVariables;
    }

    /**
     * @param BlockInterface $block
     * @param string $templateFile
     * @param array $dictionary
     * @return string|void
     */
    public function render(BlockInterface $block, $templateFile, array $dictionary = [])
    {
        // Step 1: preapre the view, passing the block as reference
        // Step 2: render the output as html
        // Step 3: return the rendered html
    }
}
