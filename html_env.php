<?php

function html_header($title)
{
    print "<!DOCTYPE html>\n";

    print "<html>\n";
    print "<head>\n";
    print "<meta charset=\"utf-8\" />\n";
    print "<meta name=\"viewport\" content=\"width=device-width,  initial-scale=1\"/>";
    print "<link rel=\"stylesheet\" href=\"bootstrap.min.css\"/>\n";
    print "<title>$title</title>\n";
    print "</head>\n";

    print "<body>\n";
}

function html_footer()
{
    print "</body>\n";
    print "</html>\n";
}
?>
