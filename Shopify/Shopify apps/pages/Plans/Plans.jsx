import React, {useEffect} from "react";
import {
    ButtonGroup,
    Button,
    Page,
    Layout,
    Card,
    Text,
    Grid, List, Badge
} from '@shopify/polaris';
import {apiPlans} from "../services/index.js";

export const Plans = () => {
    const {
        data,
        error,
        isLoading,
        isError,
    } = apiPlans.useGetPlansQuery();

    const {
        data: loadData,
        isLoading: isLoadingLoadData,
    } = apiPlans.useGetLoadDataQuery();

    const planId = loadData?.data?.plan?.id;

    console.log('data', data)

    const [subscription] = apiPlans.useSubscriptionMutation();

    const changeSubscription = (planId) => {
        subscription({plan_id: planId})
            .unwrap()
            .then(response => {
                console.log('Settings saved successfully', response);
            })
            .catch(error => {
                console.error('Error saving settings', error);
            });
    };

    if (isLoading) {
        return <div>Loading...</div>;
    }

    if (isError) {
        return <div>Error: {error.message}</div>;
    }
    console.log('data', data)
    return (
        <Page fullWidth title='Plans'>
            <Layout>
                <Layout.Section>
                    <Grid>
                        {data?.data?.map((plan) => (
                            <Grid.Cell key={plan.id} columnSpan={{ xs: 4, sm: 4, md: 4, lg: 4, xl: 4 }}>
                                <Card sectioned>
                                    <div style={{ position: 'relative', minHeight: '500px', display: 'flex', justifyContent: 'space-between', flexDirection: 'column' }}>
                                        <div>
                                            <div style={{ paddingBottom: '20px' }}>
                                                <Text variant="headingLg" as="h5">
                                                    {plan.title}
                                                </Text>
                                            </div>
                                            <div style={{ paddingBottom: '20px' }}>
                                                <Text variant="heading3xl" as="h2">
                                                    ${plan.price} <span style={{ fontSize: '14px' }}>/month</span>
                                                </Text>
                                            </div>
                                            <div style={{ paddingBottom: '20px' }}>
                                                {/* Include a description if you have that data */}
                                            </div>
                                            <div style={{ paddingBottom: '20px' }}>
                                                {plan.title.toLowerCase() === 'basic' ? (
                                                  <List type="bullet">
                                                      <List.Item>Automated integration of Collection and Product Page widgets</List.Item>
                                                      <List.Item>Store sync with entire CyclApps bikes database</List.Item>
                                                      <List.Item>Up to 1,000 store SKUs</List.Item>
                                                  </List>
                                                ) : null}
                                                {plan.title.toLowerCase() === 'standard' ? (
                                                  <div>
                                                      Same as Basic, plus:
                                                      <List type="bullet">
                                                          <List.Item>Downloadable performance reporting last 30 days</List.Item>
                                                          <List.Item>Unlimited store SKU count</List.Item>
                                                      </List>
                                                  </div>
                                                ) : null}
                                                {plan.title.toLowerCase() === 'premium' ? (
                                                  <div>
                                                      Same as Standard plus:
                                                      <List type="bullet">
                                                          <List.Item>Downloadable performance reporting with any timeframe</List.Item>
                                                      </List>
                                                  </div>
                                                ) : null}
                                            </div>
                                        </div>
                                        <div style={{ paddingBottom: '20px' }}>
                                            <Button variant="primary" large disabled={plan.id === planId} fullWidth onClick={() => changeSubscription(plan.uuid)}>
                                                {plan.id === planId ? 'Selected Plan' : 'Select Plan'}
                                            </Button>
                                        </div>
                                    </div>
                                </Card>
                            </Grid.Cell>
                        ))}
                    </Grid>
                </Layout.Section>
            </Layout>
        </Page>
    )
}
