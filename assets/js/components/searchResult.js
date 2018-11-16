import React from 'react';
import { decodeEntities } from '@wordpress/html-entities';
export default class SearchResult extends React.Component {

	constructor( props ) {
		super( props );
	}

	render() {		
		return (
			<li className="search-results-item">
				<a href={ this.props.result.link }>{ decodeEntities( this.props.result.title ) }</a>
			</li>
		)
	}
}
