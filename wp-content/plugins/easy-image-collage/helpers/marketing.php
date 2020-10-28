<?php

class EIC_Marketing {

    private $campaign = false;

    public function __construct()
    {
        $campaigns = array(
			'black-friday-2020' => array(
				'start' => new DateTime( '2020-11-25 10:00:00', new DateTimeZone( 'Europe/Brussels' ) ),
				'end' => new DateTime( '2020-12-02 10:00:00', new DateTimeZone( 'Europe/Brussels' ) ),
				'notice_title' => 'Black Friday & Cyber Monday Deal',
				'notice_text' => 'Get a 30% discount right now!',
				'page_title' => 'Black Friday Discount!',
				'page_text' => 'Good news: we\'re having a Black Friday & Cyber Monday sale and you can get a <strong>30% discount on any of our plugins</strong>. Just use this code on the checkout page: <em>BF2020</em>',
			),
			'birthday-2021' => array(
				'start' => new DateTime( '2021-01-25 10:00:00', new DateTimeZone( 'Europe/Brussels' ) ),
				'end' => new DateTime( '2021-02-01 10:00:00', new DateTimeZone( 'Europe/Brussels' ) ),
				'notice_title' => 'Celebrating my 33rd birthday',
				'notice_text' => 'Get a 30% discount right now!',
				'page_title' => 'Birthday Discount!',
				'page_text' => 'Good news: I\'m celebrating my 33rd birthday with a <strong>30% discount on any of our plugins</strong>. Just use this code on the checkout page: <em>BDAY2021</em>',
			),
		);

		$now = new DateTime();

		foreach ( $campaigns as $id => $campaign ) {
			if ( $campaign['start'] < $now && $now < $campaign['end'] ) {
				$campaign['id'] = $id;
				$this->campaign = $campaign;
				break;
			}
		}

		if ( false !== $this->campaign ) {
            add_action( 'eic_modal_notices', array( $this, 'marketing_notice' ) );
        }
    }

    public function marketing_notice()
    {
        if ( ! EasyImageCollage::is_premium_active() ) {
            $params = '?utm_source=eic&utm_medium=plugin&utm_campaign=' . urlencode( $this->campaign['id'] );

            echo '<div style="border: 1px solid darkgreen; padding: 5px; margin-bottom: 5px; background-color:rgba(0,255,0,0.15);">';
            echo '<strong>' . $this->campaign['notice_title'] . '</strong><br/>';
            echo $this->campaign['page_text'] . '<br/><br/>';
            echo '<a href="https://bootstrapped.ventures/' . $params . '" target="_blank">'  . $this->campaign['notice_text'] .  '</a>';
            echo '</div>';
        }
    }
}