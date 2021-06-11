const {__} = window.wp.i18n;
const {registerBlockType} = window.wp.blocks;

const blockStyle = {
	backgroundColor: '#900',
	color: '#fff',
	padding: '20px'
}

registerBlockType('chi-mail-machine/blocks', {
	title: __('Firsr Block'),
	icon: 'block-default',
	category: 'layout',
	edit: (props) => {
		return (
			'pl'

		);
	},
	save() {
		return 'l,'
	}
});
