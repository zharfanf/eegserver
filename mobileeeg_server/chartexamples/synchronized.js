"use strict";

function generateData() {
  var data = [{
    date: new Date(2015, 0, 1),
    value: 50
  }];
  for (var i = 2; i <= 365; i++) {
    data.push({
      date: new Date(2015, 0, i),
      value: data[data.length - 1].value + Math.random() * 2 - 1
    });
  }
  return data;
}

function generatePlotGroup(xScale, yScale) {
  var linePlot = new Plottable.Plots.Line().addDataset(new Plottable.Dataset(generateData())).x(function (d) {
    return d.date;
  }, xScale).y(function (d) {
    return d.value;
  }, yScale).attr("opacity", 0.9);

  var datasetForFocusPoint = new Plottable.Dataset();

  var selectedPoint = new Plottable.Plots.Scatter().x(function (d) {
    return d.date;
  }, xScale).y(function (d) {
    return d.value;
  }, yScale).size(10).attr("opacity", 1).addDataset(datasetForFocusPoint);

  var selectedPointHighlight = new Plottable.Plots.Scatter().x(function (d) {
    return d.date;
  }, xScale).y(function (d) {
    return d.value;
  }, yScale).size(20).attr("opacity", 0.25).addDataset(datasetForFocusPoint);

  var guideline = new Plottable.Components.GuideLineLayer(Plottable.Components.GuideLineLayer.ORIENTATION_VERTICAL).scale(xScale);

  return new Plottable.Components.Group([linePlot, guideline, selectedPoint, selectedPointHighlight]);
}

function generateInteraction(plotGroup1, plotGroup2) {
  var linePlot1 = plotGroup1.components()[0];
  var linePlot2 = plotGroup2.components()[0];

  var guideline1 = plotGroup1.components()[1];
  var guideline2 = plotGroup2.components()[1];

  var selectedPoint1 = plotGroup1.components()[2];
  var selectedPoint2 = plotGroup2.components()[2];

  var interaction = new Plottable.Interactions.Pointer();
  interaction.onPointerMove(function (point) {
    var nearestEntityByX = linePlot1.entityNearestByXThenY(point);
    var otherNearestEntityByX = linePlot2.entityNearestByXThenY(point);
    selectedPoint1.datasets()[0].data([nearestEntityByX.datum]);
    selectedPoint2.datasets()[0].data([otherNearestEntityByX.datum]);
    guideline1.value(nearestEntityByX.datum.date);
    guideline2.value(otherNearestEntityByX.datum.date);
  });

  return interaction;
}

var xScale = new Plottable.Scales.Time();
var yScaleTop = new Plottable.Scales.Linear();
var yScaleBottom = new Plottable.Scales.Linear();

var plotGroupTop = generatePlotGroup(xScale, yScaleTop);
var plotGroupBottom = generatePlotGroup(xScale, yScaleBottom);

generateInteraction(plotGroupTop, plotGroupBottom).attachTo(plotGroupTop.components()[0]);
generateInteraction(plotGroupBottom, plotGroupTop).attachTo(plotGroupBottom.components()[0]);

var xAxisTop = new Plottable.Axes.Time(xScale, "bottom");
var yAxisTop = new Plottable.Axes.Numeric(yScaleTop, "left");

var xAxisBottom = new Plottable.Axes.Time(xScale, "bottom");
var yAxisBottom = new Plottable.Axes.Numeric(yScaleBottom, "left");

var chart1 = new Plottable.Components.Table([[yAxisTop, plotGroupTop], [null, xAxisTop]]);

var chart2 = new Plottable.Components.Table([[yAxisBottom, plotGroupBottom], [null, xAxisBottom]]);

var table = new Plottable.Components.Table([[chart1], [chart2]]);

table.renderTo("svg#example");
