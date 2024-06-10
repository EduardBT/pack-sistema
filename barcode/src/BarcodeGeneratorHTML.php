<?php

namespace Picqer\Barcode;

class BarcodeGeneratorHTML extends BarcodeGenerator
{
    /**
     * Return an HTML representation of barcode.
     * This original version uses pixel based widths and heights. Use Dynamic HTML version for better quality representation.
     *
     * @param string $barcode code to print
     * @param string $type type of barcode
     * @param int $widthFactor Width of a single bar element in pixels.
     * @param int $height Height of a single bar element in pixels.
     * @param string $foregroundColor Foreground color for bar elements as '#333' or 'orange' for example (background is transparent).
     * @return string HTML code.
     */
    public function getBarcode($barcode, $type, int $widthFactor = 2, int $height = 50, string $foregroundColor = 'black')
    {
        $barcodeData = $this->getBarcodeData($barcode, $type);

        $html = '<div style="font-size:0;position:relative;width: 60px;' . ($barcodeData->getWidth() * $widthFactor) . 'px;height:' . ($height) . '60px;">' . PHP_EOL;

        $positionHorizontal = 0;
        /** @var BarcodeBar $bar */
        foreach ($barcodeData->getBars() as $bar) {
            $barWidth = round(($bar->getWidth() * $widthFactor), 6);
            $barHeight = round(($bar->getHeight() * $height / $barcodeData->getHeight()), 6);

            if ($bar->isBar() && $barWidth > 0) {
                $positionVertical = round(($bar->getPositionVertical() * $height / $barcodeData->getHeight()), 6);

                // draw a vertical bar
                $html .= '<div style="background-color:' . $foregroundColor . ';width:' . $barWidth . 'px;height:' . $barHeight . 'px;position:absolute;left:' . $positionHorizontal . 'px;top:' . $positionVertical . (($positionVertical > 0) ? '60px' : '') . '">&nbsp;</div>' . PHP_EOL;
            }

            $positionHorizontal += $barWidth;
        }

        $html .= '</div>' . PHP_EOL;

        return $html;
    }
}
