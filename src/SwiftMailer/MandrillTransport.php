<?php

namespace remiii\MandrillMailerBundle\src\SwiftMailer ;

use \Swift_Events_EventDispatcher ;
use \Swift_Events_EventListener ;
use \Swift_Events_SendEvent ;
use \Swift_Mime_Message ;
use \Swift_Transport ;
use \Swift_Attachment ;

use Mandrill ;

class MandrillTransport implements Swift_Transport
{


    /**
     * @type Swift_Events_EventDispatcher
     */
    protected $_evenDispatcher ;

    /**
     * @type Mandrill
     */
    private $_mandrill ;

    /**
     * @type boolean
     */
    private $_async ;


    /**
     * Test if this Transport mechanism has started.
     * Not used.
     *
     * @return boolean
     */
    public function isStarted ( )
    {
        return false ;
    }

    /**
    * Start this Transport mechanism.
    * Not used.
    */
    public function start ( )
    {
    }

    /**
    * Stop this Transport mechanism.
    * Not used.
    */
    public function stop ( )
    {
    }


    /**
     * @param Swift_Events_EventDispatcher $dispatcher
     */
    public function __construct ( Swift_Events_EventDispatcher $eventDispatcher )
    {
        $this -> _eventDispatcher = $eventDispatcher ;
    }

    /**
     * Creates with the api key a mandrill object
     *
     * @param string $apiKey
     */
    public function setApiKey ( $apiKey )
    {
        $this -> _mandrill = new Mandrill ( $apiKey ) ;
    }

    /**
     * Set async param
     *
     * @param string $async
     */
    public function setAsync ( $async )
    {
        $this -> _async = $async ;
    }

    /**
     * Send the given Message.
     *
     * Recipient/sender data will be retrieved from the Message API.
     * The return value is the number of recipients who were accepted for delivery.
     *
     * @param Swift_Mime_Message $message
     * @param null $failedRecipients
     *
     * @return int Number of messages sent
     */
    public function send ( Swift_Mime_Message $message , &$failedRecipients = null )
    {

        $failedRecipients = ( array ) $failedRecipients ;
        $count = 0 ;

        if ( $evt = $this -> _eventDispatcher -> createSendEvent ( $this , $message ) )
        {
            $this -> _eventDispatcher -> dispatchEvent ( $evt , 'beforeSendPerformed' ) ;
            if ( $evt -> bubbleCancelled ( ) )
            {
                return 0 ;
            }
        }

        $toHeader = $message -> getHeaders ( ) -> get ( 'To' ) ;
        if ( !$toHeader )
        {
            $this -> throwException ( new Swift_TransportException ( 'Cannot send message without a recipient' ) ) ;
        }

        $mandrillMessageData = $this -> getMandrillMessageData ( $message ) ;

        try {
            $result = $this -> _mandrill -> messages -> send ( $mandrillMessageData , $this -> _async ) ;
            foreach ( $result as $item )
            {
                if ( $item [ 'status' ] == 'sent' )
                {
                    $count++ ;
                }
                else
                {
                    $failedRecipients [ ] = $item [ 'email' ] ;
                }
            }
        } catch ( \Exception $e ) {
        }

        if ( $evt )
        {
            if ( $count > 0 )
            {
                $evt -> setResult ( Swift_Events_SendEvent::RESULT_SUCCESS ) ;
                $evt -> setFailedRecipients ( $failedRecipients ) ;
            }
            else
            {
                $evt -> setResult ( Swift_Events_SendEvent::RESULT_FAILED ) ;
                $evt -> setFailedRecipients ( $failedRecipients ) ;
            }
            $this -> _eventDispatcher -> dispatchEvent ( $evt , 'sendPerformed' ) ;
        }

        return $count ;
    }

    /**
     * Register a plugin.
     *
     * @param Swift_Events_EventListener $plugin
     */
    public function registerPlugin ( Swift_Events_EventListener $plugin )
    {
        $this -> _eventDispatcher -> bindEventListener ( $plugin ) ;
    }


    /**
     * So far sends only basic html email and attachments
     *
     * https://mandrillapp.com/api/docs/messages.php.html#method-send
     *
     * @param Swift_Mime_Message $message
     *
     * @return array Mandrill Send Message
     */
    protected function getMandrillMessageData ( Swift_Mime_Message $message )
    {
        $fromAddresses = $message -> getFrom ( ) ;
        $formEmails = array_keys ( $fromAddresses ) ;
        $toAddresses = $message -> getTo ( ) ;
        $ccAddresses = ( $message -> getCc ( ) ) ? $message -> getCc ( ) : array ( ) ;
        $bccAddresses = ( $message -> getBcc ( ) ) ? $message -> getBcc ( ) : array ( ) ;
        $replyToAddresses = ( $message -> getReplyTo ( ) ) ? $message -> getReplyTo ( ) : array ( ) ;
        $headers = ( $message -> getHeaders ( ) ) ? $message -> getHeaders ( ) : array ( ) ;

        $to = array ( ) ;
        $mandrillHeaders = array ( ) ;
        $attachments = array ( ) ;

        foreach ( $toAddresses as $toEmail => $toName )
        {
            $to [ ] = array (
                'email' => $toEmail ,
                'name'  => $toName ,
                'type'  => 'to'
            ) ;
        }

        foreach ( $ccAddresses as $ccEmail => $ccName )
        {
            $to [ ] = array (
                'email' => $ccEmail ,
                'name'  => $ccName ,
                'type'  => 'cc'
            ) ;
        }

        foreach ( $bccAddresses as $bccEmail => $bccName )
        {
            $to [ ] = array (
                'email' => $bccEmail ,
                'name'  => $bccName ,
                'type'  => 'bcc'
            ) ;
        }

        foreach ( $replyToAddresses as $replyToEmail => $replyToName )
        {
            if ( $replyToName )
            {
                $mandrillHeaders [ 'Reply-To' ] = sprintf ( '%s <%s>' , $replyToEmail , $replyToName ) ;
            }
            else
            {
                $mandrillHeaders [ 'Reply-To' ] = $replyToEmail ;
            }
        }

        if ( $headers -> get ( 'X-MC-InlineCSS' ) !== null )
        {
            $inlineCss = $headers -> get ( 'X-MC-InlineCSS' ) -> getValue ( ) ;
        }
        else
        {
            $inlineCss = null ;
        }

        if ( $headers -> get ( 'X-MC-Tags' ) !== null )
        {
            $tags = explode ( ',' , $headers -> get ( 'X-MC-Tags' ) -> getValue ( ) ) ;
        }
        else
        {
            $tags = null ;
        }

        foreach ( $message -> getChildren ( ) as $child )
        {
            if ( $child instanceof Swift_Attachment )
            {
                $attachments [ ] = array (
                    'type'    => $child -> getContentType ( ) ,
                    'name'    => $child -> getFilename ( ) ,
                    'content' => base64_encode ( $child -> getBody ( ) )
                ) ;
            }
        }

        $mandrillMessageData = array (
            'html'              => $message -> getBody ( ) ,
            // txt
            'subject'           => $message -> getSubject ( ) ,
            'from_email'        => $formEmails [ 0 ] ,
            'from_name'         => $fromAddresses [ $formEmails [ 0 ] ] ,
            'to'                => $to ,
            'headers'           => $mandrillHeaders ,
            'inline_css'        => $inlineCss ,
            'tags'              => $tags
        ) ;

        if ( count ( $attachments ) > 0 )
        {
            $mandrillMessageData [ 'attachments' ] = $attachments ;
            // images
        }

        return $mandrillMessageData ;
    }

    /**
     * @param Swift_Mime_Message $message
     * @param string $mime_type
     *
     * @return null|\Swift_Mime_MimeEntity
     */
    protected function getMIMEPart ( Swift_Mime_Message $message , $mime_type )
    {
        $htmlPart = null ;
        foreach ( $message -> getChildren ( ) as $part )
        {
            if ( strpos ( $part -> getContentType ( ) , 'text/html' ) === 0 )
            {
                $htmlPart = $part ;
            }
        }
        return $htmlPart ;
    }

    /** Throw a TransportException, first sending it to any listeners */
    protected function throwException ( Swift_TransportException $e )
    {
        if ($evt = $this -> _eventDispatcher -> createTransportExceptionEvent ( $this , $e ) )
        {
            $this -> _eventDispatcher -> dispatchEvent ( $evt , 'exceptionThrown' ) ;
            if ( ! $evt -> bubbleCancelled ( ) )
            {
                throw $e ;
            }
        }
        else
        {
            throw $e ;
        }
    }

}

