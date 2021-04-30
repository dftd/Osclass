<?php
/*
 * Copyright 2020 OsclassPoint.com
 *
 * Osclass maintained & developed by OsclassPoint.com
 * you may not use this file except in compliance with the License.
 * You may download copy of Osclass at
 *
 *     https://osclass-classifieds.com/download
 *
 * Software is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 */


/**
 * @param null $type
 * @param null $last_exec
 */
function osc_runAlert($type = null, $last_exec = null)
{
  $mUser = User::newInstance();
  if (!in_array($type, array('HOURLY', 'DAILY', 'WEEKLY', 'INSTANT'))) {
    return;
  }

  if ($last_exec == null) {
    $cron    = Cron::newInstance()->getCronByType($type);
    $last_exec = '0000-00-00 00:00:00';
    if (is_array($cron)) {
      $last_exec = $cron[ 'd_last_exec' ];
    }
  }

  $internal_name = 'alert_email_hourly';
  switch ($type) {
    case 'HOURLY':
      $internal_name = 'alert_email_hourly';
      break;
    case 'DAILY':
      $internal_name = 'alert_email_daily';
      break;
    case 'WEEKLY':
      $internal_name = 'alert_email_weekly';
      break;
    case 'INSTANT':
      $internal_name = 'alert_email_instant';
      break;
  }

  $active   = true;
  $searches = Alerts::newInstance()->findByTypeGroup($type, $active);

  foreach ($searches as $s_search) {
    // Get if there're new ads on this search
    $json       = $s_search[ 's_search' ];
    $array_conditions = (array)json_decode($json);

    $new_search = Search::newInstance();
    $new_search->setJsonAlert($array_conditions);

    $new_search->addConditions(sprintf(" %st_item.dt_pub_date > '%s' ", DB_TABLE_PREFIX, $last_exec));

    $items    = $new_search->doSearch();
    $totalItems = $new_search->count();

    if (count($items) > 0) {
      // If we have new items from last check
      // Catch the user subscribed to this search
      $alerts = Alerts::newInstance()->findUsersBySearchAndType($s_search[ 's_search' ], $type, $active);

      if (count($alerts) > 0) {
        $ads = '<table id="alert-items" cellspacing="0" cellpadding="8">';
        foreach ($items as $item) {
          $ads .= '<tr>';
          $resource = ItemResource::newInstance()->getResource($item[ 'pk_i_id' ]);

          if(isset($resource['pk_i_id']) && $resource['pk_i_id'] > 0) {
            $path = osc_apply_filter('resource_path', osc_base_url().$resource['s_path']);
            $img_link = $path.$resource['pk_i_id']."_thumbnail.".$resource['s_extension'];
          } else {
            $img_link = osc_base_url() . 'oc-includes/osclass/gui/images/no_photo.gif';
          }

          $ads .= '<td width="80" style="border-top:1px solid #ddd"><img src="' . $img_link . '" width="80"/></td>';
          $ads .= '<td align="left" style="border-top:1px solid #ddd"><a href="' . osc_item_url_ns($item[ 'pk_i_id' ]) . '">' . $item[ 's_title' ] . '</a><br/><span>' . osc_highlight($item[ 's_description' ], 115) . '</span></td>';

          $ads .= '</tr>';
        }

        $ads .= '</table>';

        foreach ($alerts as $alert) {
          $user = array();
          if ($alert[ 'fk_i_user_id' ] > 0) {
            $user = $mUser->findByPrimaryKey($alert[ 'fk_i_user_id' ]);
          } else {
            $user = $mUser->findByEmail($alert[ 's_email' ]);
          }
          if (!isset($user[ 's_name' ]) || @$user[ 's_name' ] == '') {
            $user = array(
              's_name'  => $alert[ 's_email' ],
              's_email' => $alert[ 's_email' ]
            );
          }
          if (count($alert) > 0) {
            osc_run_hook('hook_' . $internal_name, $user, $ads, $alert, $items, $totalItems);
            AlertsStats::newInstance()->increase(date('Y-m-d'));
          }
        }
      }
    }
  }
}