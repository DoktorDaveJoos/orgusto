import {addHours} from 'date-fns';

export const DoneMapping = {
  true: 1,
  false: 0,
};

export const buildQueryParams = (state, newPageLink = null) => {
  // fixed query params
  const params = {
    done: DoneMapping[state.filter.showFulfilled],
    past: DoneMapping[state.filter.past],
    search: state.search.query,
  };

  // optional filter
  if (state.filter.dateFilter.active) {
    if (state.filter.dateFilter.mode === 'range') {
      const {start, end} = state.filter.dateRange;
      params.from = start.toISOString();
      // TODO fix timezone issue
      const consolidatedTo = addHours(end, 1);
      params.to = consolidatedTo.toISOString();
    }
    if (state.filter.dateFilter.mode === 'single') {
      const {singleDate} = state.filter;
      params.from = singleDate.toISOString();
    }
  }

  // if no search query -> apply pagination
  if (state.search.query.length === 0) {
    if (newPageLink) {
      params.page = buildPaginationParams(newPageLink).get('page');
    } else if (state.reservations.meta.links?.find(link => link.active)) {
      const activePage = state.reservations.meta.links.find(link => link.active);
      params.page = buildPaginationParams(activePage.url).get('page');
    }
  }

  return new URLSearchParams(params);
};

export const buildPaginationParams = url => {
  const parsed = new URL(url);
  return new URLSearchParams(parsed.search);
};
