Legacy 2018 extension
-

Removed features:
* Template Operator 'attribute'



Template Operator 'attribute'
-
This template operator is for debugging only. In a
template file you can use that operator to dump out
a variable value. For example:

{array(1,2,3)|attribute('show')}

That operator got replaced by a new operator called
'dump'. Here is an example:

{array(1,2,3)|dump()}
