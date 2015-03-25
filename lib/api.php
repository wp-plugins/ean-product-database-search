<?php

class PleepApi {

    private $_apiUrl;
    private $_eanUrl;
    private $_data;
    private $_ean;

    public function __construct() {
        $this->_apiUrl = 'http://www.saleshare.de/api';
        $this->_eanUrl = $this->_apiUrl. '/product';
    }

    public function getData($ean) {
        $this->_ean = $ean;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $this->_eanUrl. '/'. $ean);
        $result = curl_exec($ch);
        curl_close($ch);

        $this->_data = json_decode($result, true);
        return $this;
    }

    public function getHtml() {
        if (@$this->_data['success'] == false || !isset($this->_data['success'])) {
            $html = '<div class="pleep-product-view">';

            $html .= '<h3 style="float:left;margin-top: 0px;">' . $this->_data['Title'] . '<br /><small class="text-muted" style="font-weight:normal">EAN: ' . $this->_data['EAN'] . '</small></h3>';
            $html .= '';
            $html .= '<div class="pleep-product-description"><div class="pleep-product-image" style="float:right;width:30%"><img src="' . $this->_data['Image'] . '" style="width:100%;" /></div>' . $this->_data['Description_Short'] . '<div style="clear:both"></div></div>';
            $html .= '<div class="pleep-best-price">Bester Preis: <strong>' . number_format($this->_data['bestPrice'], 2, ',', '.') . ' | ' . $this->_data['ReviewsCount'] . ' Bewertungen</strong>';
            $html .= '<hr /><div class="pleep-merchant-table"><table style="width:100%" class="table"><tr>
                    <th>Preis</th>
                    <th>Verkäufer</th>
                    <td></td>
                </tr>';

            foreach ($this->_data['Merchants'] as $merchant) {
                $html .= '<tr>
                            <td>' . number_format($merchant['Price'], 2, ',', '.') . '</td>
                            <td>' . $merchant['Name'] . '</td>
                            <td><a href="' . $merchant['Link'] . '" target="_blank">Mehr</a> | <a href="' . $merchant['DirectLink'] . '" target="_blank">Zum Anbieter</a></td>
                        </tr>';
            }

            $html .= '</table></div>';

            $html .= '<div style="clear:both"></div><div style="text-align:center;"><small><i>Powered by <a href="http://pleep.net/" target="_blank">pleep.net</a></i></small></div></div>';
        } else {
            $html = '<div class="pleep-not-found"><small><i>Es wurden keine Produktdaten zum EAN-Code <strong>'. $this->_ean. '</strong> gefunden. Bitte suchen Sie auf <a href="http://pleep.net/search" target="_blank">pleep.net</a> nach einem Produkt und fügen Sie den EAN-Code ein.</i></small></div>';
        }

        return $html;
    }
}
