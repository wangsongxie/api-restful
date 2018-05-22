<?php

return [

//    'accessKeyId' => 'LTAIJrk5UQ8GWixV',
//    'accessSecret' => 'tKrvKiUlS0zCAizfGbT9VhlqAwE0bT',
//    'roleArn' => "acs:ram::1886388997109665:role/dog126-oss-sts",
    // AccessKeyID
    'key' => env('ALIYUN_STS_KEY', 'LTAIkvwq1nDmFOdh'),

    // AccessKeySecret
    'secret' => env('ALIYUN_STS_SECRET', 'B77nPzufRnAY0QlpuiKCwJIrBstAl4'),

    // RoleArn
    'role_arn' => env('ALIYUN_STS_ROLE_ARN', 'acs:ram::1886388997109665:role/dog126-app-oss-sts'),

    // Token的失效时间，最少是900s
    'expire_time' => env('ALIYUN_STS_EXPIRE_TIME', 900),

    // Token所要拥有的权限
    'policy' => [
        "Statement" => [
            [
                "Action" => [
                    "oss:*"
                ],
                "Effect" => "Allow",
                "Resource" => ["acs:oss:*:*:*"]
            ]
        ],
        "Version" => "1"
    ],

];
