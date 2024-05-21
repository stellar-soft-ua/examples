import React from "react";
import {
    Text,
    LegacyCard as Card,
    Label,
    Button,
    ButtonGroup,
    Stack,
    FormLayout,
    Tooltip,
    Icon,
} from "@shopify/polaris";
import { useForm } from "react-hook-form";
import { yupResolver } from "@hookform/resolvers/yup";
import { DeleteMinor, CircleInformationMajor } from "@shopify/polaris-icons";
import { useTranslation } from "react-i18next";
import {
    ControlledTextField,
    ControlledSelect,
    ControlledChoiceList,
} from "../UI";
import { TitleForm } from "./TitleForm";
import { AccountModal } from "./AccountModal";
import { MarketplaceChoice } from "./MarketplaceChoice";
import { validationSchema } from "./validationSchema";

export const AccountForm = React.memo(
    ({
        accountInfo,
        onClose,
        onSubmit,
        onDelete,
        isLoading,
        deleteLoading,
        marketplaceList,
        isEditMode,
        orderTypesList,
        syncColumns,
        syncSelected,
    }) => {
        const [openDeleteModal, setOpenDeleteModal] = React.useState(false);

        const { t } = useTranslation();

        const toggleDeleteModal = React.useCallback(() => {
            setOpenDeleteModal((prev) => !prev);
        }, []);

        const { control, handleSubmit, setValue } = useForm({
            resolver: yupResolver(validationSchema),
            defaultValues: {
                region: accountInfo?.region || "",
                name: accountInfo?.name || "",
                marketplace: accountInfo?.marketplace || "",
                order_type: accountInfo?.order_type || "",
                sync_key: isNaN(syncSelected) ? syncSelected : Number(syncSelected)  || "",
            },
        });

        const handleDelete = React.useCallback(() => {
            toggleDeleteModal();
            onDelete();
        }, []);

        const clearMarketplaceOnSelect = React.useCallback(() => {
            setValue("marketplace", "");
        }, []);

        const regionOptions = React.useMemo(() => {
            if (!marketplaceList) return [];
            return Object.entries(marketplaceList).map(([key, value]) => ({
                value: key,
                label: value.title,
            }));
        }, [marketplaceList]);

        const orderTypesOptions = React.useMemo(() => {
            if (!orderTypesList) return [];
            return Object.keys(orderTypesList).map((key) => ({
                value: key,
                label: orderTypesList[key],
            }));
        }, [orderTypesList]);

        const syncColumnsOptions = React.useMemo(() => {
            if (!syncColumns) return [];
            return Object.entries(syncColumns).map(([key, value]) => ({
                value: isNaN(key) ? key : Number(key),
                label: value,
            }));
        }, [syncColumns]);

        return (
            <Card
                sectioned
                title={<TitleForm control={control} isEditMode={isEditMode} />}
            >
                <FormLayout>
                    <FormLayout.Group>
                        <ControlledTextField
                            control={control}
                            name={"name"}
                            readOnly={isEditMode}
                            label={
                                <>
                                    <Text fontWeight="bold">
                                        {t("forms.name")}
                                    </Text>
                                    <Text variant="bodySm" as="p">
                                        {isEditMode
                                            ? t("connect.edit_name")
                                            : t("connect.add_name")}
                                    </Text>
                                </>
                            }
                            placeholder={t("connect.account_name_ph")}
                            autoComplete={""}
                        />
                    </FormLayout.Group>
                    <ControlledSelect
                        placeholder={t("forms.select_region")}
                        label={
                            <Text fontWeight="bold">
                                {t("forms.select_region")}
                            </Text>
                        }
                        name={"region"}
                        control={control}
                        options={regionOptions}
                        onSelect={clearMarketplaceOnSelect}
                    />

                    <MarketplaceChoice
                        control={control}
                        marketplaceList={marketplaceList}
                        name={"marketplace"}
                        placeholder={t("connect.marketplace_placeholder")}
                        title={
                            <Text fontWeight="bold">
                                {t("connect.marketplaces")}
                            </Text>
                        }
                    />

                    <FormLayout.Group>
                        <ControlledSelect
                            control={control}
                            options={orderTypesOptions}
                            placeholder={t("connect.order_types_placeholder")}
                            name={"order_type"}
                            label={
                                <Text fontWeight="bold" as="p">
                                    {t("connect.orders_import_title")}
                                </Text>
                            }
                        />
                        <ControlledSelect
                            control={control}
                            options={syncColumnsOptions}
                            name={"sync_key"}
                            placeholder={"Select"}
                            label={
                                <Tooltip
                                    content={t(
                                        "connect.product_import_tooltip"
                                    )}
                                    preferredPosition="above"
                                    width="wide"
                                >
                                    <div className="connect-product-import-tooltip">
                                        <Text fontWeight="bold" as="p">
                                            {t("connect.product_import_title")}
                                        </Text>
                                        <span className={"help-tooltip"}>
                                            <Icon
                                                source={CircleInformationMajor}
                                            />
                                        </span>
                                    </div>
                                </Tooltip>
                            }
                        />
                    </FormLayout.Group>
                    <a
                        href="https://toolecommerce.com/terms-and-conditions"
                        target="_blank"
                    >
                        {t("connect.terms_and_conditions")}
                    </a>

                    <Stack alignment="center" distribution="equalSpacing">
                        <Stack.Item>
                            {isEditMode && (
                                <Button
                                    icon={DeleteMinor}
                                    onClick={toggleDeleteModal}
                                    destructive
                                    loading={deleteLoading}
                                >
                                    {t("common.delete")}
                                </Button>
                            )}
                        </Stack.Item>
                        <Stack.Item>
                            <ButtonGroup spacing="loose">
                                <Button onClick={onClose}>
                                    {t("common.close")}
                                </Button>
                                <Button
                                    primary
                                    onClick={handleSubmit(onSubmit)}
                                    loading={isLoading}
                                >
                                    {t("connect.save")}
                                </Button>
                            </ButtonGroup>
                        </Stack.Item>
                    </Stack>
                </FormLayout>
                <AccountModal
                    isOpen={openDeleteModal}
                    onClose={toggleDeleteModal}
                    onAction={handleDelete}
                />
            </Card>
        );
    }
);
