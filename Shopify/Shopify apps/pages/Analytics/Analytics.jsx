import React, {useCallback, useEffect, useState} from "react";
import {
    ButtonGroup,
    Button,
    Page,
    Layout,
    Card,
    Text,
    Grid,
    IndexTable,
    useIndexResourceState, useBreakpoints, EmptySearchResult, FormLayout, Popover, DatePicker
} from '@shopify/polaris';
import {apiAnalytics} from "../services/index.js";
import {usePagination} from "../hooks/index.js";

export const Analytics = () => {

    const currentDate = new Date();
    const currentMonth = currentDate.getMonth();
    const currentYear = currentDate.getFullYear();

    // State and Hooks Initialization
    const [{ month, year }, setDate] = useState({ month: currentMonth, year: currentYear });
    const [selectedDates, setSelectedDates] = useState({
        start: new Date(currentDate - 7 * 24 * 60 * 60 * 1000),
        end: new Date(currentDate),
    });

    const [popoverActive, setPopoverActive] = useState(false);

    const {
        page,
        rowsPerPage,
        onNext,
        onPrevious,
        onRowsPerPageChange,
    } = usePagination();

    // API Calls and Data Fetching
    const totalAnalyticsData = apiAnalytics.useGetTotalAnalyticsQuery();
    const analyticsData = apiAnalytics.useGetAnalyticsQuery(
        {
            page: page,        // The page number you want to request
            perPage: rowsPerPage,   // The number of items per page
        });

    const [downloadAnalytics] = apiAnalytics.useDownloadAnalyticsMutation();

    const totalAnalytics = totalAnalyticsData?.data?.data?.analytics;

    // Event Handlers and Callbacks
    const togglePopoverActive = useCallback(
        () => setPopoverActive((popoverActive) => !popoverActive),
        [],
    );

    const handleMonthChange = useCallback(
        (month, year) => setDate({month, year}),
        [],
    );

    const {selectedResources, allResourcesSelected, handleSelectionChange} =
        useIndexResourceState(analyticsData?.data?.data);

    const onDownloadSelected = useCallback(async () => {
        try {
            const response = await downloadAnalytics({id: selectedResources}).unwrap();
            const fileName = response.file;

            const fileUrl = `/csv/${fileName}`;

            const link = document.createElement('a');
            link.href = fileUrl;
            link.setAttribute('download', fileName);
            document.body.appendChild(link);
            link.click();
            link.parentNode.removeChild(link);
        } catch (error) {
            console.error('Error with download file:', error);
        }
    }, [selectedResources, downloadAnalytics]);

    const downloadAll = () => {
        console.log('Download all');
    }

    // Render Logic
    const resourceName = { singular: 'product', plural: 'products' };

    const emptyStateMarkup = (
        <EmptySearchResult
            title={'No analytics yet'}
            description={'Try changing the filters or search term'}
            withIllustration
        />
    );

    const promotedBulkActions = [
        {
            content: 'Download selected in CSV',
            onAction: onDownloadSelected,
        },
    ];

    const activator = (
        <Button onClick={togglePopoverActive} disclosure>
            Select date
        </Button>
    );

    // JSX and Return Statement
    const rowMarkup = analyticsData?.data?.data.map(
        (
            {item, id, click_count, select_count, orders},
            index,
        ) => (
            <IndexTable.Row
                id={id}
                key={id}
                selected={selectedResources.includes(id)}
                position={index}
            >
                <IndexTable.Cell>
                    <Text variant="bodyMd" fontWeight="bold" as="span">
                        {item.product}
                    </Text>
                </IndexTable.Cell>
                <IndexTable.Cell>
                    <Text as="span" alignment="center" numeric>
                        year
                    </Text>
                </IndexTable.Cell>
                <IndexTable.Cell>{item.make}</IndexTable.Cell>
                <IndexTable.Cell>{item.model}</IndexTable.Cell>
                <IndexTable.Cell>subModel</IndexTable.Cell>
                <IndexTable.Cell>
                    <Text as="span" alignment="center" numeric>
                        {item.bikes}
                    </Text>
                </IndexTable.Cell>
                <IndexTable.Cell>
                    <Text as="span" alignment="center" numeric>
                        {orders}
                    </Text>
                </IndexTable.Cell>
                <IndexTable.Cell>
                    <Text as="span" alignment="center" numeric>
                        {select_count}
                    </Text>
                </IndexTable.Cell>
            </IndexTable.Row>
        ),
    );

    return (
        <Page fullWidth title='Analytics'>
            <ui-title-bar />
            <Layout gap="500">
                <Layout.Section>
                    <Grid>
{/*                        <Grid.Cell columnSpan={{xs: 12, sm: 12, md: 12, lg: 12, xl: 12}}>
                            <Card>
                                <Badge tone="warning">On hold</Badge>
                            </Card>
                        </Grid.Cell>*/}
                        <Grid.Cell columnSpan={{xs: 6, sm: 3, md: 3, lg: 4, xl: 4}}>
                            <Card>
                                <Text as="h3" variant="headingSm" fontWeight="regular">
                                    Total Clicks
                                </Text>
                                <Text as="h3" variant="heading2xl" fontWeight="medium">
                                    {totalAnalytics?.total_clicks}
                                </Text>
                            </Card>
                        </Grid.Cell>
                        <Grid.Cell columnSpan={{xs: 6, sm: 3, md: 3, lg: 4, xl: 4}}>
                            <Card>
                                <Text as="h3" variant="headingSm" fontWeight="regular">
                                    Total Selects
                                </Text>
                                <Text as="h3" variant="heading2xl" fontWeight="medium">
                                    {totalAnalytics?.total_selects}
                                </Text>
                            </Card>
                        </Grid.Cell>
                        <Grid.Cell columnSpan={{xs: 6, sm: 3, md: 3, lg: 4, xl: 4}}>
                            <Card>
                                <Text as="h3" variant="headingSm" fontWeight="regular">
                                    Total Orders
                                </Text>
                                <Text as="h3" variant="heading2xl" fontWeight="medium">
                                    {totalAnalytics?.total_order}
                                </Text>
                            </Card>
                        </Grid.Cell>
                        <Grid.Cell columnSpan={{xs: 6, sm: 3, md: 3, lg: 4, xl: 4}}>
                            <Card>
                                <Text as="h3" variant="headingSm" fontWeight="regular">
                                    Fitment use
                                </Text>
                                <Text as="h3" variant="heading2xl" fontWeight="medium">
                                    {totalAnalytics?.total_fitments}
                                </Text>
                            </Card>
                        </Grid.Cell>
                        <Grid.Cell columnSpan={{xs: 6, sm: 3, md: 3, lg: 4, xl: 4}}>
                            <Card>
                                <Text as="h3" variant="headingSm" fontWeight="regular">
                                    Revenue
                                </Text>
                                <Text as="h3" variant="heading2xl" fontWeight="medium">
                                    {totalAnalytics?.total_revenue}
                                </Text>
                            </Card>
                        </Grid.Cell>
                    </Grid>
                </Layout.Section>
                <Layout.Section>
                    <ButtonGroup>
                        <Popover
                            active={popoverActive}
                            activator={activator}
                            onClose={togglePopoverActive}
                            ariaHaspopup={false}
                            sectioned
                        >
                            <FormLayout>
                                <DatePicker
                                    month={month}
                                    year={year}
                                    onChange={setSelectedDates}
                                    onMonthChange={handleMonthChange}
                                    selected={selectedDates}
                                    disableDatesBefore={new Date(currentDate - 30 * 24 * 60 * 60 * 1000)}
                                    disableDatesAfter={new Date(currentDate + 24 * 60 * 60 * 1000)}
                                    allowRange
                                />
                            </FormLayout>
                        </Popover>
                        <Button onClick={downloadAll}>Download all in CSV</Button>
                    </ButtonGroup>
                </Layout.Section>
                <Layout.Section>
                    <Card padding="0">
                        <IndexTable
                            condensed={useBreakpoints().smDown}
                            resourceName={resourceName}
                            itemCount={analyticsData?.data?.data ? analyticsData?.data?.data.length : 0}
                            selectedItemsCount={
                                allResourcesSelected ? 'All' : selectedResources.length
                            }
                            emptyState={emptyStateMarkup}
                            hasMoreItems
                            promotedBulkActions={promotedBulkActions}
                            onSelectionChange={handleSelectionChange}
                            headings={[
                                {title: 'Product'},
                                {title: 'Year', alignment: 'center'},
                                {title: 'Make'},
                                {title: 'Model'},
                                {title: 'Sub-model'},
                                {title: 'Number of bikes', alignment: 'center'},
                                {title: 'Number of orders', alignment: 'center'},
                                {title: 'Selects', alignment: 'center'},
                            ]}
                            pagination={{
                                hasNext: page < analyticsData?.data?.meta?.last_page,
                                hasPrevious: page > 1,
                                onNext: onNext,
                                onPrevious: onPrevious,
                                onRowsPerPageChange: onRowsPerPageChange,
                            }}
                        >
                            {rowMarkup}
                        </IndexTable>
                    </Card>
                </Layout.Section>
            </Layout>
        </Page>
    );
}
