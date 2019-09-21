<?php

abstract class Renderer {
    protected $templateFileName;

    public static $templatePcBaseDir = 'pc'.DIRECTORY_SEPARATOR;
    public static $templateSpBaseDir ='sp'.DIRECTORY_SEPARATOR;
    public static $templateCommonBaseDir = 'common'.DIRECTORY_SEPARATOR;
    public static $templateIncludeBaseDir = 'include'.DIRECTORY_SEPARATOR;

    public function __construct($templateBaseDir, $templateFileName, $isMobile) {
        $this->templateFileName = $this->resolveTemplateFileName(
            $templateBaseDir, $templateFileName, $isMobile);
    }
    
    protected function resolveTemplateFileName(
        $templateBaseDir, $templateFileName, 
        $isMobile) {
        if (!empty($templateFileName)) {
            if ($isMobile) {
                if (file_exists($templateBaseDir.Renderer::$templateSpBaseDir.$templateFileName)) {
                    return Renderer::$templateSpBaseDir.$templateFileName;
                }
                if (file_exists($templateBaseDir.Renderer::$templateCommonBaseDir.$templateFileName)) {
                    return Renderer::$templateCommonBaseDir.$templateFileName;
                }
                if (file_exists($templateBaseDir.Renderer::$templatePcBaseDir.$templateFileName)) {
                    return Renderer::$templatePcBaseDir.$templateFileName;
                }
            } else {
                if (file_exists($templateBaseDir.Renderer::$templatePcBaseDir.$templateFileName)) {
                    return Renderer::$templatePcBaseDir.$templateFileName;
                }
                if (file_exists($templateBaseDir.Renderer::$templateCommonBaseDir.$templateFileName)) {
                    return Renderer::$templateCommonBaseDir.$templateFileName;
                }
                if (file_exists($templateBaseDir.Renderer::$templateSpBaseDir.$templateFileName)) {
                    return Renderer::$templateSpBaseDir.$templateFileName;
                }
            }
            if (file_exists($templateBaseDir.Renderer::$templateIncludeBaseDir.$templateFileName)) {
                return Renderer::$templateIncludeBaseDir.$templateFileName;
            }
            throw new PageNotFoundException($templateBaseDir.':'.$templateFileName);
        } else {
            return null;
        }
    }

    abstract public function render($model);

    public function renderToString($model) {
        ob_start();
        $this->render($model);
        $result = ob_get_clean(); 
        return $result;
    }

    public static function create($model, $templateFileName, $format, $isMobile) {
        if (!empty($templateFileName)) {
            $templateFileName .= '.'.$format;
        }
        $result = null;
        if ($format === 'tpl') {
            $result = new SmartyRenderer($model, $templateFileName, $isMobile);
        } else if ($format === 'twig') {
            $result = new TwigRenderer($model, $templateFileName, $isMobile);
        } else if ($format === 'json') {
            $result = new JsonRenderer($model, $templateFileName, $isMobile);
        } else if ($format === 'dump') {
            $result = new DumpRenderer($model, $templateFileName, $isMobile);
        }
        return $result;
    }
}