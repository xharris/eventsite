<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";
    includeHeader();
 ?>

<div class="sidebar">

    <div class="header">
        <div class="site-title">Event Site</div>
        <a onclick="btn_addEvent()" class="waves-effect waves-light btn blue accent-4">Post an event</a>
        <div style="clear:both"></div>
    </div>

    <div class="event-list">
        <?php

            $events = Event::getAllEvents();
            foreach ($events as $event_id) {
                printEvent($event_id);
            }

         ?>
    </div>

    <div class="place-event-helpertext hidden">
        <div>
            <p>Click the map to place a marker for the location of your event</p>
        </div>
    </div>

    <div class="form-new-event hidden">
        <div class="input-field">
            <input id="in-title" type="text" value="Bob's day">
            <label for="in-title">Event Title</label>
        </div>
        <div class="input-field">
            <textarea id="in-description" class="materialize-textarea">Bob will have his day.</textarea>
            <label for="in-description">Event Description</label>
        </div>

        <div class="dates">
            <!-- start date/time -->
            <br>
            <label for="in-date">Start Date</label>
            <br>
            <div class="input-field">
                <input type="date" id="in-start-date" class="datepicker">
            </div>
            <div class="input-field">
                <input type="time" id="in-start-time" class="timepicker" value="00:00">
            </div>
            <!-- end date/time -->
            <br>
            <label for="in-date">End Date</label>
            <br>
            <div class="input-field">
                <input type="date" id="in-end-date" class="datepicker">
            </div>
            <div class="input-field">
                <input type="time" id="in-end-time" class="timepicker" value="23:59">
            </div>
        </div>

        <p>Visibility</p>
        <p>
            <input name="in-visibility" type="radio" id="radio1" value="public" checked />
            <label class="radio-label" for="radio1">
                <span class="one">Public</span>
                <span class="two">Visible to everyone on the map. Anyone can add theirself to the guest list.</span>
            </label>
        </p>
        <p>
          <input name="in-visibility" type="radio" id="radio2" value="private" />
          <label class="radio-label" for="radio2">
              <span class="one">Private</span>
              <span class="two">Only visible on the map to people that have the invite link.</span>
          </label>
        </p>
        <a onclick="submitEvent()" class="waves-effect waves-light btn green accent-4">Save</a>
    </div>

</div>

<div class="container-map">
    <input id="pac-input" class="controls" type="text" placeholder="Search Box">
    <div id="gmap"></div>
</div>

<!-- Google Maps -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtqhEfNzJcOg6piOShHElOnoddPjRsx4Y&libraries=places&callback=initMap" async defer></script>

<?php includeFooter(); ?>
