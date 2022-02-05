<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Infrastructure\HttpClient\TransportLayer;

class NetworkTimingsParser
{
    private array $networkTimings;

    /**
     * @param array $httpClientResponseInfo
     */
    public function __construct(array $httpClientResponseInfo)
    {
        //    time_namelookup:  0.001s
        //       time_connect:  0.037s
        //    time_appconnect:  0.000s
        //   time_pretransfer:  0.037s
        //      time_redirect:  0.000s
        // time_starttransfer:  0.092s
        //                   ----------
        //        time_total:  0.164s

        $this->networkTimings = [
            // name lookup time in MICROSECONDS
            // https://curl.se/libcurl/c/CURLINFO_NAMELOOKUP_TIME.html
            // get the name lookup time
            // Time from the start until the name resolving was completed.
            // When a redirect is followed, the time from each request is added together.
            'namelookup_time_us'    => $httpClientResponseInfo['namelookup_time_us'],

            // total time in seconds from the start until the connection to the remote host (or proxy) was completed in MICROSECONDS
            // https://curl.se/libcurl/c/CURLINFO_CONNECT_TIME.html
            // When a redirect is followed, the time from each request is added together.
            'connect_time_us'       => $httpClientResponseInfo['connect_time_us'],

            // time until the SSL/SSH handshake is completed in MICROSECONDS
            // https://curl.se/libcurl/c/CURLINFO_APPCONNECT_TIME.html
            // it took from the start until the SSL/SSH connect/handshake to the remote host was completed.
            // This time is most often close to the CURLINFO_PRETRANSFER_TIME time, except for cases such as HTTP pipelining
            // where the pretransfer time can be delayed due to waits in line for the pipeline and more.
            // When a redirect is followed, the time from each request is added together.
            'appconnect_time_us'    => $httpClientResponseInfo['appconnect_time_us'],

            // time until the file transfer start in MICROSECONDS
            // https://curl.se/libcurl/c/CURLINFO_PRETRANSFER_TIME.html
            // It took from the start until the file transfer is just about to begin.
            // This time-stamp includes all pre-transfer commands and negotiations that are specific to the particular
            // protocol(s) involved. It includes the sending of the protocol- specific protocol instructions that triggers a transfer.
            // When a redirect is followed, the time from each request is added together.
            'pretransfer_time_us'   => $httpClientResponseInfo['pretransfer_time_us'],

            // time for all redirection steps in MICROSECONDS
            // https://curl.se/libcurl/c/CURLINFO_REDIRECT_TIME.html
            // it took for all redirection steps include name lookup, connect, pretransfer and transfer before
            // final transaction was started.
            // CURLINFO_REDIRECT_TIME contains the complete execution time for multiple redirections.
            'redirect_time_us'      => $httpClientResponseInfo['redirect_time_us'],

            // time until the first byte is received in MICROSECONDS
            // it took from the start until the first byte is received by libcurl
            // https://curl.se/libcurl/c/CURLINFO_STARTTRANSFER_TIME.html
            // This includes CURLINFO_PRETRANSFER_TIME and also the time the server needs to calculate the result.
            // When a redirect is followed, the time from each request is added together.
            'starttransfer_time_us' => $httpClientResponseInfo['starttransfer_time_us'],

            // total time of previous transfer in MICROSECONDS
            // https://curl.se/libcurl/c/CURLINFO_TOTAL_TIME.html
            // total time in seconds for the previous transfer, including name resolving, TCP connect etc.
            // The double represents the time in seconds, including fractions.
            // When a redirect is followed, the time from each request is added together.
            'total_time_us'         => $httpClientResponseInfo['total_time_us'],
        ];
    }

    /**
     * @return array
     */
    public function toArrayWithMicroseconds(): array
    {
        return $this->networkTimings;
    }
}