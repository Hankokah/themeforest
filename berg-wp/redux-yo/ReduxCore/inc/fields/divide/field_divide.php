<?php

/**
 * Redux Framework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 * Redux Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with Redux Framework. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package     ReduxFramework
 * @subpackage  Field_Divide
 * @author      Daniel J Griffiths (Ghost1227)
 * @author      Dovy Paukstys
 * @version     3.0.0
 */

// Exit if accessed directly
if ( !defined ( 'ABSPATH' ) ) {
    exit;
}

// Don't duplicate me!
if ( !class_exists ( 'ReduxFramework_divide' ) ) {

    /**
     * Main ReduxFramework_divide class
     *
     * @since       1.0.0
     */
    class ReduxFramework_divide {

        /**
         * Field Constructor.
         * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
         *
         * @since         1.0.0
         * @access        public
         * @return        void
         */
        function __construct ( $field = array(), $value = '', $parent ) {
            $this->parent = $parent;
            $this->field = $field;
            $this->value = $value;
        }

        /**
         * Field Render Function.
         * Takes the vars and outputs the HTML for the field in the settings
         *
         * @since         1.0.0
         * @access        public
         * @return        void
         */
        public function render () {
            // print_r($this->field);
            // echo '</td></tr></table>';
            // echo '<div data-id="' . $this->field[ 'id' ] . '" id="divide-' . $this->field[ 'id' ] . '" class="hr ' . $this->field[ 'class' ] . '"><div class="inner"><span>&nbsp;</span></div></div>';
            // echo '<table class="form-table no-border"><tbody><tr><th colspan="2"><h3>'.(isset($this->field['title']) ? $this->field['title'] : '').'</h3></th></tr></table><table><tr>';
            // echo '<h1>test</h1>';
            echo '<div class="remove-this-row"></div></fieldset></td></tr></tbody></table>';
            echo '<div class="redux-section-header hr ' . $this->field[ 'class' ] . '" data-id="' . $this->field[ 'id' ] . '" id="divide-' . $this->field[ 'id' ] . '"><h3>'.$this->field['title'].'</h3></div>';
            echo '<table class="form-table no-border"><tbody><tr><th></th><td><fieldset>';
        }
    }
}
