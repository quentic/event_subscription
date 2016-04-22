<?php

  class EventsMember{

    function associer($event_id, $member_id){
      // mysql_query("INSERT INTO events_members (event_id, member_id) VALUE (" . $event_id . "," . $member_id . ")");
      }

    function dissocier($event_id, $member_id){
      // mysql_query("DELETE FROM events_members WHERE event_id=" . $event_id . " AND member_id=" . $member_id);
      }
  }

?>
