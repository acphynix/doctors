<?php
  /**
   * 
   *  User get schedule, serviced by GET request.
   *  INPUT:  u=user_id, s=start_date, e=end_date
   *  OUTPUT:
   *    returns a list of event objects for a particular user between specified
   *    start and end dates. An event is {start:datetime, end:datetime, data:DATA},
   *    with DATA either {type:open} OR {type:closed,patient:PATIENT}
   *    with PATIENT={user_id:int,name:string, ... }.
   *    Times which are not specified are assumed
   *          for doctors  to be unavailable,
   *      but for patients to be available
   *
   */


echo "[{'doctor':'1','schedule':[{'start':'2017-7-5 09:00','end':'2017-7-5 11:00','type':'open'}]}]";

?>