<?php

/**
 * XML parser - used to return the inner XML content body of SVG icons
 *
 * @package     SB2Media\SVGIconSystem\SVGIcons
 * @since       1.0.0
 * @author      sbarry
 * @link        http://example.com
 * @license     GNU General Public License 2.0+ and MIT License (MIT)
 */

namespace SB2Media\SVGIconSystem\SVGIcons;

use DOMNode;
use DOMDocument;

class XMLParser
{
    /**
     * DOMDocument object
     *
     * @var object
     */
    public $doc;

    /**
     * Constructor.
     *
     * @since 1.0.0
     * @param DOMDocument   $doc    DOMDocument object
     */
    public function __construct( DOMDocument $doc )
    {
        $this->doc = $doc;
    }

    /**
     * Parse the supplied XML (SVG) code.
     *
     * @since  1.0.0
     * @param  string    $xml       The XML code to be parsed
     * @param  string    $inner_tag The inner tag(s) to be removed
     * @param  string    $outer_tag The outer tag(s) to be removed
     * @return string    $xml       The parsed XML code
     */
    public function parse( $xml, $inner_tag = '', $outer_tag = '' )
    {
        $this->doc->loadXML( $xml );

        if( ! empty($inner_tag) ) {
            $this->removeInnerTags( $inner_tag );
        }

        $xml = $this->doc->saveXML();

        if( ! empty($outer_tag) ) {
            $xml = $this->removeOuterTag( $outer_tag );
        }

        return $xml;
    }

    /**
     * Remove the specified inner XML tags from the document.
     *
     * @since  1.0.0
     * @param  string   $tag    The tag to be removed
     * @return
     */
    protected function removeInnerTag( $tag )
    {
        $nodes = $this->doc->getElementsByTagName($tag);
        foreach ($nodes as $node) {
            $node->parentNode->removeChild( $node );
        }
    }

    /**
     * Remove the specified inner XML tags from the document. Can be array of tags or singular tag in a string.
     *
     * @since  1.0.0
     * @param  array|string    $inner_tag    The inner tag(s) to be removed
     * @return
     */
    protected function removeInnerTags( $inner_tag )
    {
        if( is_array( $inner_tag ) ) {
            foreach( $inner_tag as $tag ) {
                $this->removeInnerTag( $tag );
            }
            return;
        }

        if( is_string( $inner_tag ) ) {
            $this->removeInnerTag( $inner_tag );
        }
    }

    /**
     * Remove the outer XML tag.
     *
     * @since  1.0.0
     * @param  string    $tag    The tag to be removed
     * @return string    $xml   The
     */
    protected function removeOuterTag( $tag )
    {
        $nodes = $this->doc->getElementsByTagName( $tag );
        foreach( $nodes as $node ) {
            $xml = $this->getInnerXML( $node );
        }

        return $xml;
    }

    /**
     * Get the inner XML of the specified DOMNode element.
     *
     * @since  1.0.0
     * @param  DOMNode   $element    The outer node to retrieve the inner XML from
     * @return string    $innerXML   The inner XML
     */
    protected function getInnerXML( DOMNode $element )
    {
        $innerXML = '';
        $children  = $element->childNodes;

        foreach ( $children as $child )
        {
            $innerXML .= $element->ownerDocument->saveXML( $child );
        }

        return $innerXML;
    }
}
