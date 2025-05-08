import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

registerBlockType('hanscomparkstudio/double-byline', {
	title: __('Double Byline', 'double-byline'),
	icon: 'admin-users',
	category: 'widgets',
	edit: () => {
		return 'Double byline (dynamic block, front-end only)';
	},
	save: () => {
		return null; // Rendered in PHP
	},
});