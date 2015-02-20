<?php

use remiii\MandrillMailerBundle\src\SwiftMailer\MandrillTransport ;

use \Mockery as m;

/**
 * MandrillTransport Test
 */
class MandrillTransportTest extends PHPUnit_Framework_TestCase
{

    /** @var ContainerBuilder */
    protected $configuration ;

    /**
     *
     */
    public function testGlobal ( )
    {

        $bcc = null ;
        $textBody = null ;
        $htmlBody = '<html><p>Hello world!</p></html>' ;

        $mail = \Swift_Message::newInstance ( ) ;

        $mail
            -> setFrom ( 'remiii@gmail.com' )
            -> setTo ( 'matthieu@gmail.com' )
            -> setReplyTo ( 'remiii@gmail.com' )
            -> setSubject ( 'Small test' ) ;

        if ( $bcc != null )
        {
            $mail -> setBcc ( $bcc ) ;
        }
        if ( !empty ( $htmlBody ) )
        {
            $mail -> setBody ($htmlBody , 'text/html' )
                  -> addPart ( $textBody , 'text/plain' ) ;
        }
        else
        {
            $mail -> setBody ( $textBody ) ;
        }

        $service = m::mock ( 'Swift_Events_EventDispatcher' ) -> shouldIgnoreMissing ( ) ;
        $mandrillTransport = new MandrillTransport ( $service ) ;
        $mandrillTransport -> send ( $mail ) ;
    }

}

