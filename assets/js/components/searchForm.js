import React from 'react';
import SearchResults from './searchResults';

export default class SearchForm extends React.Component {

	constructor( props ) {
		super( props );

		this.getResults = this.getResults.bind( this );

		this.state = {
			results: [],
			loading: false,
			searched: false,
			lengthError: false,
			empty: false,
		};
	}

	getResults( event ) {

		const search = event.target.value;

		if ( ! search ) {
			this.setState( {
				results: [],
				loading: false,
				searched: false,
				lengthError: false,
				empty: true,
			} );

			return;
		}

		if ( search && wds_react_post_search.minimum_character_count < search.length ) {
			this.setState( {
				loading: true,
				searched: true,
				lengthError: false,
				empty: false,
			} );

			let url = wds_react_post_search.rest_search_posts.replace( '%s', search );

			let	json = fetch( url )
				.then(
					response => {
						return response.json()
					}
				)
				.then(
					results => {
						this.setState( {
							results: results,
							loading: false
						} );
					}
				);
		} else {
			this.setState( {
				results: [],
				searched: false,
				lengthError: true,
				empty: false,
			} );
		}
	}

	render() {
		return (
			<div className="search-form-input">
				<input className="search-input" type="text" onKeyUp={ this.getResults } />
				<SearchResults searched={ this.state.searched } loading={ this.state.loading } results={ this.state.results } lengthError={ this.state.lengthError } empty={ this.state.empty } />
			</div>
		)
	}
}
