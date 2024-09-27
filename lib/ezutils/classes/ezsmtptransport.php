<?php

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

/**
 * File containing the eZSMTPTransport class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version //autogentag//
 * @package lib
 */

/*!
  \class eZSMTPTransport ezsmtptransport.php
  \brief The class eZSMTPTransport does

*/

class eZSMTPTransport extends eZMailTransport
{
    function sendMail( eZMail $mail )
    {
        $ini = eZINI::instance();

        /* If email sender hasn't been specified or is empty
         * we substitute it with either MailSettings.EmailSender or AdminEmail.
         */
        if ( !$mail->senderText() )
        {
            $emailSender = $ini->variable( 'MailSettings', 'EmailSender' );
            if ( !$emailSender )
            {
                $emailSender = $ini->variable( 'MailSettings', 'AdminEmail' );
            }

            eZMail::extractEmail( $emailSender, $emailSenderAddress, $emailSenderName );

            if ( !eZMail::validate( $emailSenderAddress ) )
            {
                $emailSender = false;
            }

            if ( $emailSender )
            {
                $mail->setSenderText( $emailSender );
            }
        }

        $excludeHeaders = $ini->variable( 'MailSettings', 'ExcludeHeaders' );
        if ( count( $excludeHeaders ) > 0 )
        {
            $currentHeader = $mail->Mail->getHeaders();
            foreach( $excludeHeaders as $headerName )
            {
                $currentHeader->remove( $headerName );
            }
        }

        // If in debug mode, send to debug email address and nothing else
        if ( $ini->variable( 'MailSettings', 'DebugSending' ) == 'enabled' )
        {
            $mail->setReceiver(
                $ini->variable( 'MailSettings', 'DebugReceiverEmail' )
            );
            $mail->setCcElements( [] );
            $mail->setBccElements( [] );
        }

        $transport = Transport::fromDsn( self::generateDsn() );
        $mailer = new Mailer( $transport );

        try
        {
            $mailer->send( $mail->Mail );
            return true;
        }
        catch ( TransportExceptionInterface $e )
        {
            eZDebug::writeError( $e->getMessage(), __METHOD__ );
            return false;
        }
    }

    /**
     * @return string
     */
    static protected function generateDsn()
    {
        $ini = eZINI::instance();

        $scheme = 'smtp';
        $encryption = $ini->variable( 'MailSettings', 'TransportConnectionType' );
        if( $encryption )
        {
            $scheme = 'smtps';
        }

        $user = $ini->variable( 'MailSettings', 'TransportUser' );
        $password = $ini->variable( 'MailSettings', 'TransportPassword' );
        $port = $ini->variable( 'MailSettings', 'TransportPort' );

        // Build options array
        $options = [
            'verify_peer' => 0,
        ];

        $localDomain = $ini->variable( 'MailSettings', 'SenderHost' );
        if( $localDomain )
        {
            $options[ 'local_domain' ] = $localDomain;
        }

        //Example smtp://user:pass@smtp.example.com:port?encryption=tls
        $dsn =
            $scheme . '://' .
            ( $user ? rawurlencode( $user ) : '' ) .
            ( $password ? ':' . rawurlencode( $password ) : '' ) .
            ( $ini->variable( 'MailSettings', 'TransportServer' ) ).
            ( $port ? ':' . $port : '' );

        if( !empty( $options ) )
        {
            $dsn .= '?' . http_build_query( $options );
        }

        return $dsn;
    }
}


