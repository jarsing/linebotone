<?php

/**
 * Copyright 2016 LINE Corporation
 *
 * LINE Corporation licenses this file to you under the Apache License,
 * version 2.0 (the "License"); you may not use this file except in compliance
 * with the License. You may obtain a copy of the License at:
 *
 *   https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

require_once('./LINEBotTiny.php');

$channelAccessToken = urldecode(str_replace("+", "%2B", urlencode($_GET['token'])));
$channelSecret = urldecode(str_replace("+", "%2B", urlencode($_GET['secret'])));
$googleSpreadsheetsId = urldecode(str_replace("+", "%2B", urlencode($_GET['id'])));
$carouselType = urldecode(str_replace("+", "%2B", urlencode($_GET['type'])));

function getResultArrayByWakeup($wakeUp)
{
    global $googleSpreadsheetsId, $carouselType;

    $json = file_get_contents(sprintf('https://spreadsheets.google.com/feeds/list/%s/1/public/values?alt=json', $googleSpreadsheetsId));
    $data = json_decode($json, true);
    $result = [];

    if ($wakeUp == $data['feed']['title']['$t'])
    {
        foreach ($data['feed']['entry'] as $item) {
            $thumbnailImageUrl = empty(trim($item['gsx$thumbnailimageurl']['$t']))? 'https://linebot.one/default.jpg' : trim($item['gsx$thumbnailimageurl']['$t']);
            $title = empty(trim($item['gsx$title']['$t']))? '尚未指定標題' : trim($item['gsx$title']['$t']);
            $text = empty(trim($item['gsx$text']['$t']))? '尚未指定描述' : trim($item['gsx$text']['$t']);

            $actions = [];

            if (!empty(trim($item['gsx$action1label']['$t'])))
            {
                if (!empty(trim($item['gsx$action1uri']['$t'])))
                {
                    if (isset($carouselType) && $carouselType == 'flex')
                    {
                        array_push($actions, [
                            'type' => 'button',
                            'style' => 'primary',
                            'margin' => 'sm',
                            'action' => [
                                'type' => 'uri',
                                'label' => trim($item['gsx$action1label']['$t']),
                                'uri' => trim($item['gsx$action1uri']['$t']),
                            ]
                        ]);
                    }
                    else
                    {
                        array_push($actions, [
                            'type' => 'uri',
                            'label' => trim($item['gsx$action1label']['$t']),
                            'uri' => trim($item['gsx$action1uri']['$t']),
                        ]);    
                    }
                }
                else if (!empty(trim($item['gsx$action1text']['$t'])))
                {
                    if (isset($carouselType) && $carouselType == 'flex')
                    {
                        array_push($actions, [
                            'type' => 'button',
                            'style' => 'primary',
                            'margin' => 'sm',
                            'action' => [
                                'type' => 'message',
                                'label' => trim($item['gsx$action1label']['$t']),
                                'text' => trim($item['gsx$action1text']['$t']),
                            ]
                        ]);
                    }
                    else
                    {
                        array_push($actions, [
                            'type' => 'message',
                            'label' => trim($item['gsx$action1label']['$t']),
                            'text' => trim($item['gsx$action1text']['$t']),
                        ]);
                    }
                }
                else
                {
                    if (isset($carouselType) && $carouselType == 'flex')
                    {
                        array_push($actions, [
                            'type' => 'button',
                            'style' => 'primary',
                            'margin' => 'sm',
                            'action' => [
                                'type' => 'postback',
                                'label' => '尚未指定動作',
                                'data' => 'action=not_set',
                            ]
                        ]);
                    }
                    else
                    {
                        array_push($actions, [
                            'type' => 'postback',
                            'label' => '尚未指定動作',
                            'data' => 'action=not_set',
                        ]);
                    }
                }
            }

            if (!empty(trim($item['gsx$action2label']['$t'])))
            {
                if (!empty(trim($item['gsx$action2uri']['$t'])))
                {
                    if (isset($carouselType) && $carouselType == 'flex')
                    {
                        array_push($actions, [
                            'type' => 'button',
                            'style' => 'primary',
                            'margin' => 'sm',
                            'action' => [
                                'type' => 'uri',
                                'label' => trim($item['gsx$action2label']['$t']),
                                'uri' => trim($item['gsx$action2uri']['$t']),
                            ]
                        ]);
                    }
                    else
                    {
                        array_push($actions, [
                            'type' => 'uri',
                            'label' => trim($item['gsx$action2label']['$t']),
                            'uri' => trim($item['gsx$action2uri']['$t']),
                        ]);    
                    }
                }
                else if (!empty(trim($item['gsx$action2text']['$t'])))
                {
                    if (isset($carouselType) && $carouselType == 'flex')
                    {
                        array_push($actions, [
                            'type' => 'button',
                            'style' => 'primary',
                            'margin' => 'sm',
                            'action' => [
                                'type' => 'message',
                                'label' => trim($item['gsx$action2label']['$t']),
                                'text' => trim($item['gsx$action2text']['$t']),
                            ]
                        ]);
                    }
                    else
                    {
                        array_push($actions, [
                            'type' => 'message',
                            'label' => trim($item['gsx$action2label']['$t']),
                            'text' => trim($item['gsx$action2text']['$t']),
                        ]);
                    }
                }
                else
                {
                    if (isset($carouselType) && $carouselType == 'flex')
                    {
                        array_push($actions, [
                            'type' => 'button',
                            'style' => 'primary',
                            'margin' => 'sm',
                            'action' => [
                                'type' => 'postback',
                                'label' => '尚未指定動作',
                                'data' => 'action=not_set',
                            ]
                        ]);
                    }
                    else
                    {
                        array_push($actions, [
                            'type' => 'postback',
                            'label' => '尚未指定動作',
                            'data' => 'action=not_set',
                        ]);
                    }
                }
            }

            if (count($actions) == 0)
            {
                if (isset($carouselType) && $carouselType == 'flex')
                {
                    array_push($actions, [
                        'type' => 'button',
                        'style' => 'primary',
                        'margin' => 'sm',
                        'action' => [
                            'type' => 'postback',
                            'label' => '尚未指定動作',
                            'data' => 'action=not_set',
                        ]
                    ]);
                }
                else
                {
                    array_push($actions, [
                        'type' => 'postback',
                        'label' => '尚未指定動作',
                        'data' => 'action=not_set',
                    ]);
                }
            }

            if (isset($carouselType) && $carouselType == 'flex')
            {
                $candidate = [
                    'type' => 'bubble',
                    'header' => [
                        'type' => 'box',
                        'layout' => 'vertical',
                        'contents' => [
                            [
                                'type' => 'text',
                                'text' => $title,
                                'color' => '#007aff',
                                'size' => 'lg',
                                'weight' => 'bold',
                                'wrap' => true,
                            ]
                        ]
                    ],
                    'body' => [
                        'type' => 'box',
                        'layout' => 'vertical',
                        'contents' => [
                            [
                                'type' => 'text',
                                'text' => $text,
                                'wrap' => true,
                            ],
                            [
                                'type' => 'image',
                                'size' => 'full',
                                'url' => $thumbnailImageUrl,
                                'margin' => 'lg',
                            ]
                        ]
                    ],
                    'footer' => [
                        'type' => 'box',
                        'layout' => 'vertical',
                        'contents' => $actions
                        ]
                    ];
            }
            else
            {
                $candidate = [
                    'thumbnailImageUrl' => $thumbnailImageUrl,
                    'title' => $title,
                    'text' => $text,
                    'defaultAction' => $actions[0],
                    'actions' => $actions,
                ];
            }

            array_push($result, $candidate);
        }

        if (count($result) > 0)
        {
            // Only the first 40 items will show, since there are only 4 rows available
            $result = array_slice($result, 0, 40);

            if (count($result) <= 10) 
            {
                if (isset($carouselType) && $carouselType == 'flex')
                {
                    return [
                        [
                            'type' => 'flex',
                            'altText' => "為您精選下列{$wakeUp}",
                            'contents' => [
                                'type' => 'carousel',
                                'contents' => $result,
                            ],
                        ],
                        [
                            'type' => 'text',
                            'text' => '推薦以上 ' . count($result) . '個' . $wakeUp
                        ]
                    ];
                }
                else
                {
                    return [
                        [
                            'type' => 'template',
                            'altText' => "為您精選下列{$wakeUp}",
                            'template' => [
                                'type' => 'carousel',
                                'columns' => $result,
                            ],
                        ],
                        [
                            'type' => 'text',
                            'text' => '推薦以上 ' . count($result) . '個' . $wakeUp
                        ]
                    ];
                }
            } 
            else if (count($result) <= 20) 
            {
                $result1 = array_slice($result, 0, 10);
                $result2 = array_slice($result, 10);

                if (isset($carouselType) && $carouselType == 'flex')
                {
                    return [
                        [
                            'type' => 'flex',
                            'altText' => "為您精選下列{$wakeUp}",
                            'contents' => [
                                'type' => 'carousel',
                                'contents' => $result1,
                            ],
                        ],
                        [
                            'type' => 'flex',
                            'altText' => "為您精選下列{$wakeUp}",
                            'contents' => [
                                'type' => 'carousel',
                                'contents' => $result2,
                            ],
                        ],
                        [
                            'type' => 'text',
                            'text' => '推薦以上兩排共 ' . count($result) . '個' . $wakeUp
                        ]
                    ];
                }
                else
                {
                    return [
                        [
                            'type' => 'template',
                            'altText' => "為您精選下列{$input}",
                            'template' => [
                                'type' => 'carousel',
                                'columns' => $result1,
                            ],
                        ],
                        [
                            'type' => 'template',
                            'altText' => "為您精選下列{$input}",
                            'template' => [
                                'type' => 'carousel',
                                'columns' => $result2,
                            ],
                        ],
                        [
                            'type' => 'text',
                            'text' => '推薦以上兩排共 ' . count($result) . '個' . $wakeUp
                        ]
                    ];
                }
            } 
            else if (count($result) <= 30) 
            {
                $result1 = array_slice($result, 0, 10);
                $result2 = array_slice($result, 10, 10);
                $result3 = array_slice($result, 20);

                if (isset($carouselType) && $carouselType == 'flex')
                {
                    return [
                        [
                            'type' => 'flex',
                            'altText' => "為您精選下列{$wakeUp}",
                            'contents' => [
                                'type' => 'carousel',
                                'contents' => $result1,
                            ],
                        ],
                        [
                            'type' => 'flex',
                            'altText' => "為您精選下列{$wakeUp}",
                            'contents' => [
                                'type' => 'carousel',
                                'contents' => $result2,
                            ],
                        ],
                        [
                            'type' => 'flex',
                            'altText' => "為您精選下列{$wakeUp}",
                            'contents' => [
                                'type' => 'carousel',
                                'contents' => $result3,
                            ],
                        ],
                        [
                            'type' => 'text',
                            'text' => '推薦以上三排共 ' . count($result) . '個' . $wakeUp
                        ]
                    ];
                }
                else
                {
                    return [
                        [
                            'type' => 'template',
                            'altText' => "為您精選下列{$input}",
                            'template' => [
                                'type' => 'carousel',
                                'columns' => $result1,
                            ],
                        ],
                        [
                            'type' => 'template',
                            'altText' => "為您精選下列{$input}",
                            'template' => [
                                'type' => 'carousel',
                                'columns' => $result2,
                            ],
                        ],
                        [
                            'type' => 'template',
                            'altText' => "為您精選下列{$input}",
                            'template' => [
                                'type' => 'carousel',
                                'columns' => $result3,
                            ],
                        ],
                        [
                            'type' => 'text',
                            'text' => '推薦以上三排共 ' . count($result) . '個' . $wakeUp
                        ]
                    ];
                }
            }
            else if (count($result) <= 40) 
            {
                $result1 = array_slice($result, 0, 10);
                $result2 = array_slice($result, 10, 10);
                $result3 = array_slice($result, 20, 10);
                $result4 = array_slice($result, 30);

                if (isset($carouselType) && $carouselType == 'flex')
                {
                    return [
                        [
                            'type' => 'flex',
                            'altText' => "為您精選下列{$wakeUp}",
                            'contents' => [
                                'type' => 'carousel',
                                'contents' => $result1,
                            ],
                        ],
                        [
                            'type' => 'flex',
                            'altText' => "為您精選下列{$wakeUp}",
                            'contents' => [
                                'type' => 'carousel',
                                'contents' => $result2,
                            ],
                        ],
                        [
                            'type' => 'flex',
                            'altText' => "為您精選下列{$wakeUp}",
                            'contents' => [
                                'type' => 'carousel',
                                'contents' => $result3,
                            ],
                        ],
                        [
                            'type' => 'flex',
                            'altText' => "為您精選下列{$wakeUp}",
                            'contents' => [
                                'type' => 'carousel',
                                'contents' => $result4,
                            ],
                        ],
                        [
                            'type' => 'text',
                            'text' => '推薦以上四排共 ' . count($result) . '個' . $wakeUp
                        ]
                    ];
                }
                else
                {
                    return [
                        [
                            'type' => 'template',
                            'altText' => "為您精選下列{$input}",
                            'template' => [
                                'type' => 'carousel',
                                'columns' => $result1,
                            ],
                        ],
                        [
                            'type' => 'template',
                            'altText' => "為您精選下列{$input}",
                            'template' => [
                                'type' => 'carousel',
                                'columns' => $result2,
                            ],
                        ],
                        [
                            'type' => 'template',
                            'altText' => "為您精選下列{$input}",
                            'template' => [
                                'type' => 'carousel',
                                'columns' => $result3,
                            ],
                        ],
                        [
                            'type' => 'template',
                            'altText' => "為您精選下列{$input}",
                            'template' => [
                                'type' => 'carousel',
                                'columns' => $result4,
                            ],
                        ],
                        [
                            'type' => 'text',
                            'text' => '推薦以上四排共 ' . count($result) . '個' . $wakeUp
                        ]
                    ];
                }
            }
        }
    }

    return $result;
}

function getResultArrayByKeyword($keword)
{
    global $googleSpreadsheetsId, $carouselType;

    $json = file_get_contents(sprintf('https://spreadsheets.google.com/feeds/list/%s/2/public/values?alt=json', $googleSpreadsheetsId));
    $data = json_decode($json, true);
    $result = [];

    foreach ($data['feed']['entry'] as $item) {
        if (mb_strpos($keword, trim($item['gsx$keyword']['$t'])) !== false) {
            array_push($result, [
                'type' => 'text',
                'text' => trim($item['gsx$response']['$t'])
            ]);
        }
    }

    if (count($result) > 0)
    {
        // Only the first 5 items will show
        $result = array_slice($result, 0, 5);
    }

    return $result;
}

$client = new LINEBotTiny($channelAccessToken, $channelSecret);
foreach ($client->parseEvents() as $event) {
    switch ($event['type']) {
        case 'message':
            $message = $event['message'];
            switch ($message['type']) {
                case 'text':
                    $input = $message['text'];

                    $result = getResultArrayByWakeup($input);

                    if (count($result) > 0)
                    {
                        $client->replyMessage([
                            'replyToken' => $event['replyToken'],
                            'messages' => $result
                        ]);
                    }
                    else
                    {
                        $result = getResultArrayByKeyword($input);

                        if (count($result) > 0)
                        {
                            $client->replyMessage([
                                'replyToken' => $event['replyToken'],
                                'messages' => $result
                            ]);
                        }
                        else
                        {
                            $client->replyMessage([
                                'replyToken' => $event['replyToken'],
                                'messages' => [
                                    [
                                        'type' => 'text',
                                        'text' => "目前沒有與「{$input}」有關的回覆內容。",
                                    ],
                                ],
                            ]);
                        }
                    }

                    break;
                default:
                    error_log('Unsupported message type: ' . $message['type']);
                    break;
            }
            break;
        default:
            error_log('Unsupported event type: ' . $event['type']);
            break;
    }
};
