<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Preview\TrustedComms;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;

/**
 * PLEASE NOTE that this class contains preview products that are subject to change. Use them with caution. If you currently do not have developer preview access, please contact help@twilio.com.
 */
class PhoneCallList extends ListResource {
    /**
     * Construct the PhoneCallList
     *
     * @param Version $version Version that contains the resource
     * @return \Twilio\Rest\Preview\TrustedComms\PhoneCallList
     */
    public function __construct(Version $version) {
        parent::__construct($version);

        // Path Solution
        $this->solution = array();

        $this->uri = '/Business/PhoneCalls';
    }

    /**
     * Create a new PhoneCallInstance
     *
     * @param string $from The originating Phone Number
     * @param string $to The terminating Phone Number
     * @param string $url The Twiml URL
     * @param array|Options $options Optional Arguments
     * @return PhoneCallInstance Newly created PhoneCallInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function create($from, $to, $url, $options = array()) {
        $options = new Values($options);

        $data = Values::of(array(
            'From' => $from,
            'To' => $to,
            'Url' => $url,
            'Reason' => $options['reason'],
        ));

        $payload = $this->version->create(
            'POST',
            $this->uri,
            array(),
            $data
        );

        return new PhoneCallInstance($this->version, $payload);
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString() {
        return '[Twilio.Preview.TrustedComms.PhoneCallList]';
    }
}