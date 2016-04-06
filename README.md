# Flag Examples

This code sample shows scripts that are run after the A&S course catalog importer to set various flags used in the catalog interface.

###flag_uk_core
The most important script splits data from a csv string containing UK Core requirement codes along with the course numbers that satisfy them. Each course is then flagged appropriately.

###Other Flag Files
The other files each set flags based on a pattern (e.g. flag_online finds courses with section number 2xx, which are always online at UK). Like the UK Core script, they perform a query on the database to find the courses that should be flagged.
