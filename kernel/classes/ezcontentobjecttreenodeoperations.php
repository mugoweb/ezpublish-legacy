<?php
/**
 * File containing the eZContentObjectTreeNodeOperations class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version //autogentag//
 * @package kernel
 */

/**
 * Class eZContentObjectTreeNodeOperations
 *
 * @deprecated Use eZContentOperationCollection instead
 */
class eZContentObjectTreeNodeOperations
{
    /**
     * @deprected use eZContentOperationCollection::moveNode instead
     * @param $nodeID
     * @param $newParentNodeID
     * 
     * @return boolean
     */
    static function move( $nodeID, $newParentNodeID )
    {
        $node = eZContentObjectTreeNode::fetch( $nodeID );
        if ( !$node )
            return false;

        $object = $node->object();
        if ( !$object )
            return false;

        $objectID = $object->attribute( 'id' );

        $result = eZContentOperationCollection::moveNode( $nodeID, $objectID, $newParentNodeID );

        return $result[ 'status' ];
    }
}


?>
