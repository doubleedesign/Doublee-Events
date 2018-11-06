# Doublee-Events
A set of files that can be integrated into a theme and/or plugin to provide simple events display in a non-calendar format.

Requirements:
* [Advanced Custom Fields](https://www.advancedcustomfields.com)
* Google Maps API key (or just remove the map stuff if you don't want it)

File/directory structure and template markup is designed to go with my starter theme, [Double-E-Foundation](https://github.com/doubleedesign/Double-E-Foundation), but could easily be adjusted to suit your own. I have not included CSS so it should be easy for you to apply your own design.

Included:
* Event custom post type
* [ACF](https://www.advancedcustomfields.com) fields for event details
* Event archive template that automatically shows the next upcoming event at the top with its map and preview of details, and shows preview tiles of other 
events, separated into Upcoming or Previous
* Single event template that shows the event details, and automatically shows the ticketing link only if the event is upcoming

Note that you will need to add your own Google Maps API key to `template-parts/minimap.php`. The minimap functionality is based on [Doublee-Maps]
(https://github.com/doubleedesign/Doublee-Maps) but has been adjusted to just show one point on each map.