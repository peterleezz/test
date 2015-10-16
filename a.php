<?php

$card_type="董事卡";
 $valid_number=0;
                    if(preg_match('/[1|一]年卡/u', $card_type))
                    {
                       $valid_time =12;
                    }else  if(preg_match('/[2|二|两]年卡/u', $card_type))
                    {
                       $valid_time =24;
                    }else  if(preg_match('/[3|三]年卡/u', $card_type))
                    {
                       $valid_time =36;
                    }
                    else  if(preg_match('/半年(.*)卡/u', $card_type))
                    {
                       $valid_time =6;
                    }else  if(preg_match('/季(度)?卡/u', $card_type))
                    {
                       $valid_time =3;
                    }else  if( preg_match('/(\d+)(个)?月卡/i', $card_type,$matches))
                    {
                       $valid_time =$matches[1];echo $valid_time;die();
                    }

                    else
                    {
                      $valid_time =12;
                    }
echo $valid_time;