import React from 'react';
import SearchResult from './searchResult';

export default class SearchResults extends React.Component {

	constructor( props ) {
		super( props );
	}

	render() {

		let results = '',
			resultsClass = '';

		if ( this.props.loading ) {

			results      = <p>{ wds_react_post_search.loading_text }</p>;
			resultsClass = ' loading performed-action';

		} else if ( ! this.props.empty && this.props.lengthError ) {

			results      = <p>{wds_react_post_search.length_error}</p>;
			resultsClass = ' character-length performed-action';

		} else if ( 0 < this.props.results.length ) {

			const queryResults = this.props.results.map( result => {
				return(
					<SearchResult key={ result.id } result={ result } />
				);
			} );

			results      = <ul className="search-results-list">{ queryResults }</ul>;
			resultsClass = ' has-results performed-action';

		} else if ( this.props.searched ) {

			results      = <p>{ wds_react_post_search.no_results_text }</p>;
			resultsClass = ' no-results performed-action';

		}

		if ( ! results ) {
			return null;
		}

		return (
			<div className={ `search-results-container${ resultsClass }` }>
				{ results }
			</div>
		)
	}
}
