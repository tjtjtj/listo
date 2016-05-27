<?php
namespace Listo;

use LSS\Array2XML;

/**
 * XmlAdapter.
 *
 * @author Jun Takeuchi <jakeun.mob@gmail.com>
 */
class XmlAdapter
{
    public function buckets($buckets)
    {
        $func = function($b) {
            return $b->toArray();
        };
        $arr = [
            'Owner' => [
                'ID' => 8050,
                'DisplayName' => 'buckettest00002'
            ],
        ];
        if (count($buckets) > 0) {
            $func = function($b) {
                return $b->toArray();
            };
            $arr['Buckets'] = [
                'Bucket' => array_map($func, $buckets),
            ];
        }
        $xml = Array2XML::createXML('ListAllMyBucketsResult', $arr);
        $xml->formatOutput = false;
        return $xml->saveXML();
    }

    public function objects($bucket, $objects)
    {
        $arr = [
            '@attributes' => [
                'xmlns' => 'http://s3.amazonaws.com/doc/2006-03-01/',
            ],
            'Name' => $bucket->name,
            'Prefix' => '',
            'Marker' => null,
            'MaxKeys' => 1000,
            'IsTruncated' => false,
        ];
        if (count($objects) > 0) {
            $func = function($o) {
                return $o->toArray();
            };
            $arr['Contents'] = array_map($func, $objects);
        }
        $xml = Array2XML::createXML('ListBucketResult', $arr);
        $xml->formatOutput = false;
        return $xml->saveXML();
    }

    public function objectAcl($filepath)
    {
        $arr = [
            '@attributes' => [
                'xmlns' => 'http://s3.amazonaws.com/doc/2006-03-01/',
            ],
            'Owner' => [
                'ID' => 1234,
                'DisplayName' => 'buckettest00002'
            ],
            'AccessControlList' => [
                'Grant' => [
                    'Grantee' => [
                        'ID' => 1234,
                        'DisplayName' => 'buckettest00002'
                    ],
                    'Permission' => 'FULL_CONTROL',
                ],
            ],
        ];
        $xml = Array2XML::createXML('Error', $arr);
        $xml->formatOutput = false;
        return $xml->saveXML();
    }

    public function noSuchKey($filepath)
    {
        $arr = [
            '@attributes' => [
                'xmlns' => 'http://s3.amazonaws.com/doc/2006-03-01/',
            ],
            'Code' => 'NoSuchKey',
            'Message' => 'NoSuchKey',
            'Key' => $filepath,
            'RequestId' => 1,
            'HostId' => 1,
        ];
        $xml = Array2XML::createXML('Error', $arr);
        $xml->formatOutput = false;
        return $xml->saveXML();
    }

    public function noSuchBucket($bucketname)
    {
        $arr = [
            '@attributes' => [
                'xmlns' => 'http://s3.amazonaws.com/doc/2006-03-01/',
            ],
            'Code' => 'NoSuchBucket',
            'Message' => 'NoSuchBucket',
            'Key' => $bucketname,
            'RequestId' => 1,
            'HostId' => 1,
        ];
        $xml = Array2XML::createXML('Error', $arr);
        $xml->formatOutput = false;
        return $xml->saveXML();
    }
}
